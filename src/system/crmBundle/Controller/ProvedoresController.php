<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use system\crmBundle\Entity\Provedores;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use system\crmBundle\Form\ProvedoresType;


class ProvedoresController extends Controller
{
	public function indexAction(){
		$user=$this->getUser();
		$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
		if(!$permisos->getprovedoresModulo() ){
			$this->get('session')->getFlashBag()->add('error','No tienes permisos para ver este modulo ');
			return $this->redirect($this->generateUrl('index'));
		}
		$provedores = $this->getDoctrine()->getManager()
		->createQueryBuilder()
		->select('p')
		->from('crmBundle:Provedores', 'p')
		->orderBy('p.orden', 'ASC')
		->getQuery()
		->getResult();
		    	
		$estados=$this->getDoctrine()->getManager()
		->createQueryBuilder()
		->select('p.estado')
		->distinct()
		->from('crmBundle:Provedores', 'p')
		->orderBy('p.estado', 'DESC')
		->getQuery()
		->getResult();
		
		$municipio=$this->getDoctrine()->getManager()
		->createQueryBuilder()
		->select('p.municipio')
		->distinct()
		->from('crmBundle:Provedores', 'p')
		->orderBy('p.municipio', 'DESC')
		->getQuery()
		->getResult();
    	
    	return $this->render('crmBundle:Provedores:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'provedores'),
    			'permisos'=>$permisos,
    			'entities'=>$provedores,
    			'estados'=>$estados,
    			'municipios'=>$municipio
    	));
    		
    }
    public function handlerAction(Request $request, $idProvedor=0){
    	$user=$this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	$em = $this->getDoctrine()->getManager();
    	$provedoresExistentes = $em ->getRepository('crmBundle:Provedores')->find($idProvedor);
    	if (!$provedoresExistentes){//si no existe el provedor 
    		if(!$permisos->getProvedoresAgregar()){
    			$this->get('session')->getFlashBag()->add('error','No tienes permisos para agregar');
    			return $this->redirectToRoute('ProvedoresIndex');
    		}
    		$header='Agregar Provedor';
    		$nombre='';
    		$provedoresNew = new Provedores();
    		$form =$this->createForm(new ProvedoresType(), $provedoresNew);
    		$form->handleRequest($request);
    		if($form->isValid()){
    			$em->persist($provedoresNew);
    			$em->flush();
    			$this->get('session')->getFlashBag()->add('mensaje','Se a agregado el provedor a la base de datos');
    			return $this->redirect($this->generateUrl('ProvedoresIndex', array()));
    		}
    		
    		
    	}else{
    		$header= 'Editar Provedor';
    		$nombre= $provedoresExistentes->getNombre();
    		if(!$permisos->getProvedoresEditar()){
    			$this->get('session')->getFlashBag()->add('error','No tienes permisos para editar');
    			return $this->redirectToRoute('ProvedoresIndex');
    		}
    		if($provedoresExistentes->getId()!=$idProvedor){
    			$this->get('session')->getFlashBag()->add('error','No existe este provedor con este id');
    			return $this->redirectToRoute('ProvedoresIndex');
    		}
    		date_default_timezone_set('America/Mexico_City');
    		$now = new \DateTime();
    		$form=$this->createForm(new ProvedoresType(), $provedoresExistentes);
    		$form ->handleRequest($request);
    		if($form->isValid()){
    			$provedoresExistentes
    			->setFechaModificacion($now);
    			$em->flush();
    			$this->get('session')->getFlashBag()->add('mensaje','Se ha actualizado los datos del provedor correctamente');
    			return $this->redirect($this->generateUrl('ProvedoresIndex', array()));
    		}
    		
    	}
    	return $this->render('crmBundle:Provedores:agregar.html.twig',
    			array ('mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'provedores'),
    					'header'=>$header,
    					'form' => $form->createView(),
    					'permisos'=>$permisos,
    					'idUsuario'=>$user->getId(),
    					'nombre'=>$nombre,
    	
    			));
    }
    
    public function eliminarAction($idProvedor){
    	$user=$this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	$em = $this->getDoctrine()->getManager();
    	$provedoresExistentes = $em ->getRepository('crmBundle:Provedores')->find($idProvedor);
    	if(!$permisos->getProvedoresEliminar()){
    		$this->get('session')->getFlashBag()->add('error','No Tienes los permisos para eliminar');
    		return $this->redirectToRoute('ProvedoresIndex');
    	}
    	$em->remove($provedoresExistentes);
    	$em->flush();
    	$this->get('session')->getFlashBag()->add('mensaje','El Provedor se a borrado de esta lista');
    	return $this->redirectToRoute('ProvedoresIndex');
    	
    }
    public function getramoAction(){
    	$user=$this->getUser();
    	$provedoresRamo = $this->getDoctrine()->getManager()
    	->createQueryBuilder()
    	->select('p.ramo')
    	->distinct()
    	->from('crmBundle:Provedores', 'p')
    	->orderBy('p.ramo', 'DESC')
    	->getQuery()
    	->getResult();
    	
    	$etiquetasArray= array();
    	foreach ($provedoresRamo as $ramo){
    		$etiquetasExplode = explode( ',', $ramo['ramo'] );
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
    public function buscarAction(Request $request){
    	$user = $this->getUser();
    	$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
    	
    	$nombre=$request->get('nombre');
    	$contacto=$request->get('contacto');
    	$telefono=$request->get('telefono');
    	$estado=$request->get('estado');
    	$municipio=$request->get('municipio');
    	$ramo=$request->get('ramo');
    	
    	
    	if($nombre.$contacto.$telefono.$estado.$municipio.$ramo==''){
    		$response = new JsonResponse();
    		$response->setData(array('provedores'=>array()));
    		return $response;
    	}
    	
    	$parameters = array();
    	
    	if($nombre!=''){
    		$parameters['nombre']="%$nombre%";
    		$nombreP= ' p.nombre like :nombre ';
    	}else $nombreP='';
    	if($contacto!=''){
    		$parameters['contacto']="%$contacto%";
    		$contactoP=' p.contacto like :contacto ';
    		$nombreP == '' ? $contactoP : $contactoP=" and $contactoP";
    	}else $contactoP='';
    	if($telefono!=''){
    		$parameters['telefono']="%$telefono%";
    		$telefonoP=' p.telefono like :telefono ';
    		$nombreP.$contactoP == '' ? $telefonoP : $telefonoP=" and $telefonoP";
    	}else $telefonoP='';
    	if($estado!=''){
    		$parameters['estado']="%$estado%";
    		$estadoP=' p.estado like :estado ';
    	}else $estadoP='';
    	if($municipio!=''){
    		$parameters['municipio']="%$municipio%";
    		$municipioP=' p.municipio like :municipio ';
    		$estadoP == '' ? $municipioP : $municipioP=" and $municipioP";
    	}else $municipioP='';
    	if($ramo!=''){
    		$parameters['ramo']="%$ramo%";
    		$ramoP=' p.ramo like :ramo ';
    		$estadoP.$municipioP == '' ? $ramoP : $ramoP=" and $ramoP";
    	}else $ramoP='';
    	
    	$nombreP.$contactoP.$telefonoP == '' ? $datosPrincipales='' : $datosPrincipales= " ( $nombreP $contactoP $telefonoP )";
    	$estadoP.$municipioP.$ramoP== '' ? $datosSecundarios='' : $datosSecundarios="  ( $estadoP $municipioP $ramoP )";
    	
    	($datosPrincipales !='' and $datosSecundarios!='') ?  $datosSecundarios = ' and '.$datosSecundarios : true;
    	
    	$em = $this->getDoctrine()->getManager();
    	//fullquery
    	$query = $em->createQueryBuilder()
    	->select("
				p.id, p.nombre, p.contacto,
				p.ramo, CONCAT(p.direccion,' ', p.municipio,' ', p.estado) as direccion, p.telefono, p.telefono2, p.otro, p.ramo,
				p.formaPago , p.email, p.web" )
    					->from('crmBundle:Provedores', 'p')
    					->where("$datosPrincipales $datosSecundarios")
    	->setParameters($parameters)
    	->setMaxResults( 30 )
    	->getQuery();
    	
    	$probedoresResultados=$query->getResult();
    	$responseArray= array();
    	foreach ($probedoresResultados as $datos){
    		$responseArray[]= array(
    				'id'=>$datos['id'],
    				'nombre'=>$datos['nombre'],
    				'contacto'=>$datos['contacto'],
    				'ramo'=>$datos['ramo'],
    				'direccion'=>$datos['direccion'],
    				'telefono'=>$datos['telefono'],
    				'telefono2'=>$datos['telefono2'],
    				'otro'=>$datos['otro'],
    				'ramo'=>$datos['ramo'],
    				'formaPago'=>$datos['formaPago'],
    				'email'=>$datos['email'],
    				'web'=>$datos['web'],
    		);
    	}
    	
    	$response = new JsonResponse();
    	$response->setData(array('provedores'=>$responseArray));
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
    		$idProvedores= $item['idProvedor'];
    		$orden= $item['orden'];
    		$query = $em->createQuery(
    				'UPDATE
				crmBundle:Provedores p
				SET  p.orden=  :orden
				WHERE p.id = :idProvedores')
    				->setParameters(array(
    						'idProvedores'=> $idProvedores,
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
