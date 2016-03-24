<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use system\crmBundle\Entity\Maquinaria;
use system\crmBundle\Form\MaquinariaType;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    	->orderBy('m.id', 'DESC')
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
    		$query = $em->createQuery(
    				'UPDATE
				    crmBundle:Maquinaria m
				    SET  m.isActive=  :isActive
				WHERE m.id = :idMaquinaria'
    				)->setParameters(array(
    						'idMaquinaria'=> $idMaquinaria,
    						'isActive'=>$isActive));
    	
    				$query->execute();
    	   	}
    	$response = new JsonResponse();
    	$response->setData(array(
    			'success' => 1
    	));
    	return $response;
    }
		
    
}
