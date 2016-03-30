<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use system\crmBundle\Entity\Maquinaria;
use system\crmBundle\Form\MaquinariaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class MaquinariaController extends Controller
{
    public function indexAction(){
    	$user = $this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	if(!$permisos->getMaquinariaModulo()){
    		$this->get('session')->getFlashBag()->add('error','No tienes permisos para ver este modulo ');
    		return $this->redirect($this->generateUrl('index'));
    	}
    	$maquinaria = $this->getDoctrine()->getManager()
    	->createQueryBuilder()
    	->select('m')
    	->from('crmBundle:Maquinaria', 'm')
    	->orderBy('m.orden', 'ASC')
    	->getQuery()
    	->getResult();
    	return $this->render('crmBundle:Maquinaria:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'maquinaria'),
    			'permisos'=>$permisos,
    			'entities'=>$maquinaria
    	));
    		
    }
    public function handlerAction(Request $request,  $idMaquinaria=0){	
    	$user= $this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	$em =$this->getDoctrine()->getManager();
    	$maquinariaExistente= $em->getRepository('crmBundle:Maquinaria')->find($idMaquinaria);
    	if (!$maquinariaExistente){
    		if(!$permisos->getMaquinariaAgregar()){
    			$this->get('session')->getFlashBag()->add('error','No tienes permisos para agregar');
    			return $this->redirectToRoute('MaquinariaIndex');
    		}
    		$header='Agregar Maquinaria';
    		$nombre='';
    		$maquinariaNew =new Maquinaria();
    		$form =$this->createForm(new MaquinariaType() , $maquinariaNew);
    		$form->handleRequest($request);
    		if($form->isValid()){
    			$maquinariaNew
    			->setIdUsuario($user->getId());
    			$em->persist($maquinariaNew);
    			$em->flush();
    			$this->get('session')->getFlashBag()->add('mensaje','Se a agregado el registro correctamente');
    			return $this->redirect($this->generateUrl('MaquinariaEditar', array('idMaquinaria'=>$maquinariaNew->getId())));
    		}
    	}else {
    		$header='Editar Maquinaria';
    		$nombre = $maquinariaExistente->getNombre();
    		if(!$permisos->getMaquinariaEditar()){
    			$this->get('session')->getFlashBag()->add('error','No tienes permisos para editar');
    			return $this->redirectToRoute('MaquinariaIndex');
    		}
    		if($maquinariaExistente->getId()!=$idMaquinaria){
    			$this->get('session')->getFlashBag()->add('error','No existe este provedor con este id');
    			return $this->redirectToRoute('MaquinariaIndex');
    		}
    		$form=$this->createForm(new MaquinariaType(), $maquinariaExistente);
    		$form->handleRequest($request);
    		date_default_timezone_set('America/Mexico_City');
    		$now = new \DateTime();
    		if($form->isValid()){
    			$maquinariaExistente
    			->setFechaModificacion($now);
    			$em->flush();
    			$this->get('session')->getFlashBag()->add('mensaje','Se ha actualizado los datos correctamente');
    			return $this->redirect($this->generateUrl('MaquinariaIndex', array()));
    		}
    		
    	}
    	return $this->render('crmBundle:Maquinaria:agregar.html.twig',
    			array ('mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'mauinaria'),
    					'header'=>$header,
    					'form' => $form->createView(),
    					'permisos'=>$permisos,
    					'idUsuario'=>$user->getId(),
    					'nombre'=>$nombre,
    					 
    			));
    }
    public function eliminarAction($idMaquinaria){
    	$user=$this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	$em = $this->getDoctrine()->getManager();
    	$maquinariaExistente = $em ->getRepository('crmBundle:Maquinaria')->find($idMaquinaria);
    	if(!$permisos->getMaquinariaEliminar()){
    		$this->get('session')->getFlashBag()->add('error','No Tienes los permisos para eliminar');
    		return $this->redirectToRoute('MaquinariaIndex');
    	}
    	$em->remove($maquinariaExistente);
    	$em->flush();
    	$this->get('session')->getFlashBag()->add('mensaje','Registro eliminado correctamente');
    	return $this->redirectToRoute('MaquinariaIndex');
    	 
    }
    public function isActiveAction(Request $request){
    	$user = $this->getUser();
    	
    	$content = $request->getContent();
    	if (!empty($content)){
    		$params = json_decode($content, true); // 2nd param to get as array
    	}
    	$em = $this->getDoctrine()->getManager();
    	foreach ($params as $maquinaria){
    		$idMaquinaria= $maquinaria['idMaquinaria'];
    		$isActive= $maquinaria['isActive'];
    		date_default_timezone_set('America/Mexico_City');
    		$now = new \DateTime();
    		$query = $em->createQuery(
    				'UPDATE
				    crmBundle:Maquinaria m
				    SET  m.isActive=  :isActive, m.fechaModificacion = :now
				WHERE m.id = :idMaquinaria'
    				)->setParameters(array(
    						'idMaquinaria'=> $idMaquinaria,
    						'isActive'=>$isActive,
    						'now'=>$now
    				));
    	
    				$query->execute();
    		
    	   	}
    	$response = new JsonResponse();
    	$response->setData(array(
    			'success' => 1
    	));
    	return $response;
    }
	public function descargarinventarioAction(Request $request){
		//http://obtao.com/blog/2013/12/export-data-to-a-csv-file-with-symfony/
		$container = $this->container;
		$response = new StreamedResponse(function() use($container) {
			$user = $this->getUser();
			$em = $this->getDoctrine()->getManager();
			$query = $em->createQueryBuilder()
			->select('m.eco, m.numeroSerie, m.nombre, m.years, m.modelo, m.status, m.marca, m.notas')
			->from('crmBundle:Maquinaria', 'm')
			->where("not ( m.notas = '' and m.notas is null) and m.isActive= :isActive")
			->addOrderBy('m.status', 'DESC')
			->setParameters(array(
					'isActive' => "1"
			))
			->getQuery();
			$maquinaria=$query->getResult();
			
			
			$csv = "ECO,NumeroSerie,Nombre,Years,Modelo,Status,Marca,Notas\r\n";
			foreach ($maquinaria as $item){
				foreach($item as $element){
					if($element instanceof DateTime)
						$csv .= $element->format('Y-m-d'); //Converts the Datetime to string for the given format
						else
							$csv .= utf8_decode(str_replace(',', ';', preg_replace( "/\r|\n/", "", $element )));
							$csv .= ",";
				}
				$csv .= "\r\n"; //Adds new line
			}
			$fp = fopen('php://output', 'r+');
			fputs($fp, $csv);
			fclose($fp);
		});
			$response->headers->set('Content-Type', 'application/force-download');
			$response->headers->set('Content-Disposition','attachment; filename="inventario.csv"');
			return $response;
	}
	public function busquedaAction(Request $request){
		$user = $this->getUser();
		$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
		 
		$eco=$request->get('eco');
		$nombre=$request->get('nombre');
		$numeroSerie=$request->get('numeroSerie');
		$modelo=$request->get('modelo');
		$marca=$request->get('marca');
		$status=$request->get('status');
		 
		if($nombre.$marca.$eco.$numeroSerie.$modelo.$status==''){
			$response = new JsonResponse();
			$response->setData(array('maquinaria'=>array()));
			return $response;
		}
		 
		$parameters = array();
		 
		if($eco!=''){
			$parameters['eco']="%$eco%";
			$ecoP= ' m.eco like :eco ';
		}else $ecoP='';
		if($nombre!=''){
			$parameters['nombre']="%$nombre%";
			$nombreP=' m.nombre like :nombre ';
			$ecoP == '' ? $nombreP : $nombreP=" and $nombreP";
		}else $nombreP='';
		if($numeroSerie!=''){
			$parameters['numeroSerie']="%$numeroSerie%";
			$numeroSerieP=' m.numeroSerie like :numeroSerie ';
			$ecoP.$nombreP == '' ? $numeroSerieP : $numeroSerieP=" and $numeroSerieP";
		}else $numeroSerieP='';
		if($modelo!=''){
			$parameters['modelo']="%$modelo%";
			$modeloP=' m.modelo like :modelo ';
		}else $modeloP='';
		if($marca!=''){
			$parameters['marca']="%$marca%";
			$marcaP=' m.marca like :marca ';
			$modeloP == '' ? $marcaP : $marcaP=" and $marcaP";
		}else $marcaP='';
		if($status!=''){
			$parameters['status']="%$status%";
			$statusP=' m.status like :status ';
			$modeloP.$modeloP == '' ? $statusP : $statusP=" and $statusP";
		}else $statusP='';
		 
		$ecoP.$numeroSerieP.$nombreP == '' ? $datosPrincipales='' : $datosPrincipales= " ( $ecoP $numeroSerieP $nombreP )";
		$modeloP.$marcaP.$statusP== '' ? $datosSecundarios='' : $datosSecundarios="  ( $modeloP $marcaP $statusP )";
		 
		($datosPrincipales !='' and $datosSecundarios!='') ?  $datosSecundarios = ' and '.$datosSecundarios : true;
		 
		$em = $this->getDoctrine()->getManager();
		//fullquery
		$query = $em->createQueryBuilder()
		->select("m.id, m.eco, m.numeroSerie, m.nombre, m.years, m.modelo, m.status, 
				m.marca, m.isActive")
						->from('crmBundle:Maquinaria', 'm')
						->where("$datosPrincipales $datosSecundarios")
						->setParameters($parameters)
						->setMaxResults( 30 )
						->getQuery();
		
		$MaquinariaResultados=$query->getResult();
		$responseArray= array();
		foreach ($MaquinariaResultados as $datos){
			$responseArray[]= array(
					'id'=>$datos['id'],
					'eco'=>$datos['eco'],
					'numeroSerie'=>$datos['numeroSerie'],
					'nombre'=>$datos['nombre'],
					'years'=>$datos['years'],
					'modelo'=>$datos['modelo'],
					'status'=>$datos['status'],
					'marca'=>$datos['marca'],
					'isActive'=>$datos['isActive'],
			);
		}
		$response = new JsonResponse();
		$response->setData(array('maquinaria'=>$responseArray));
		return $response;
		
	}
	public function busquedanombreAction(){
		$user=$this->getUser();
		$nombreMaquinaria = $this->getDoctrine()->getManager()
		->createQueryBuilder()
		->select('m.nombre')
		->distinct()
		->from('crmBundle:Maquinaria', 'm')
		->orderBy('m.nombre', 'DESC')
		->getQuery()
		->getResult();
		 
		$etiquetasArray= array();
		foreach ($nombreMaquinaria as $item){
			$etiquetasExplode = explode( ',', $item['nombre'] );
			foreach ($etiquetasExplode as $explode){
				array_push($etiquetasArray, $explode);
			}
		}
		$etiquetasArray=array_unique($etiquetasArray);
		$etiquetasArray=array_values($etiquetasArray);
		$response = new JsonResponse();
		$response->setData($etiquetasArray);
		return $response;
	}
	
	public function reordenAction(Request $request) {
		$content = $request->getContent();
		if (!empty($content)){
			$params = json_decode($content, true); // 2nd param to get as array
		}
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		
		foreach ($params as $item){
			$idMaquinaria= $item['idMaquinaria'];
			$orden= $item['orden'];
			$query = $em->createQuery(
					'UPDATE
				crmBundle:Maquinaria m
				SET  m.orden=  :orden
				WHERE m.id = :idMaquinaria')
					->setParameters(array(
							'idMaquinaria'=> $idMaquinaria,
							'orden'=>$orden,));
					$query->execute();
		}
		$response = new JsonResponse();
		$response->setData(array(
				'success' => 1
		));
		return $response;
	}
    
}
