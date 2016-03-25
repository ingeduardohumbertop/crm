<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use system\crmBundle\Entity\Obras;
use system\crmBundle\Form\ObrasType;

class ObrasController extends Controller
{
	
	
    public function indexAction(){
    	$user = $this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	if(!$permisos->getObrasModulo() ){
    		$this->get('session')->getFlashBag()->add('error','No tienes permisos para ver este modulo ');
    		return $this->redirect($this->generateUrl('index'));
    	}
    	$obras= $this->getDoctrine()->getManager()
    	->createQueryBuilder()
    	->select("o.id , o.nombre, o.fechaInicioReal, o.fechafinalReal , o.fechaInicioPlan, o.fechaFinalPlan,
    			o.costePlanificado, o.costeReal, CONCAT(c.nombre,' ',c.apellidoP,' ',c.apellidoM) as nombreCliente,
    			CONCAT(o.calle,' ', o.colonia,' ', o.municipio) as direccion,o.estado, o.estadoObra")
    	->from('crmBundle:Obras','o')
    	->leftjoin('crmBundle:Clientes','c','WITH', 'o.idCliente = c.id')
    	->orderBy('o.fechaCreacion', 'DESC')
    	->getQuery()
    	->getResult();
    	return $this->render('crmBundle:Obras:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'obras'),
    			'permisos'=>$permisos,
    			'entities'=>$obras
    	));
    		
    }
		public function handlerAction(Request $request, $idObra = 0){
			$em = $this->getDoctrine()->getManager();
			$user = $this->getUser();
			$permisos = $this->get('crm.servicios_controller')->getPermisos($user);
			$obrasExistentes = $em ->getRepository('crmBundle:Obras')->find($idObra);
			if (!$obrasExistentes){
				if(!$permisos->getObrasAgregar() ){
					$this->get('session')->getFlashBag()->add('error','No tienes permisos para agregar');
					return $this->redirectToRoute('ObrasIndex');
				}
				$header = 'Agregar Obra';
				$nombre = '';
				$ObraNew = new Obras();
				$form= $this->createForm(new ObrasType(), $ObraNew);
				$form->handleRequest($request);
				date_default_timezone_set('America/Mexico_City');
				$now = new \DateTime();
				if($form->isValid()){
					$ObraNew
					->setIdUsuarioCreador($user->getId())
					->setFechaCreacion($now);
					$em->persist($ObraNew);
					$em->flush();
					$this->get('session')->getFlashBag()->add('mensaje','Se a agregado una obra a la base de datos');
					return $this->redirect($this->generateUrl('ObrasEditar', array('idObra'=>$ObraNew->getId()) ));
				}
			}else{
				$header='Editar Obra';
				$nombre=$obrasExistentes->getNombre();
				if(!$permisos->getObrasEditar()){
					$this->get('session')->getFlashBag()->add('error','No existe este provedor con este id');
					return $this->redirectToRoute('ObrasIndex');
				}
				$form =$this->createForm(new ObrasType(), $obrasExistentes);
				$form->handleRequest($request);
				date_default_timezone_set('America/Mexico_City');
				$now = new \DateTime();
				if($form->isValid()){
					$obrasExistentes
					->setFechaModificacion($now);
					$em->flush();
					$this->get('session')->getFlashBag()->add('mensaje','Se ha actualizado los datos correctamente');
					return $this->redirect($this->generateUrl('ObrasIndex', array()));
				}
				
			}
			return $this->render('crmBundle:Obras:agregar.html.twig',
					array ('mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'obras'),
							'header'=>$header,
							'form' => $form->createView(),
							'permisos'=>$permisos,
							'nombre'=>$nombre,
							 
					));
		}
    
}
