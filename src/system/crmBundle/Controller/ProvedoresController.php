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
    	->orderBy('p.fechaModificacion', 'DESC')
    	->getQuery()
    	->getResult();
    	return $this->render('crmBundle:Provedores:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'provedores'),
    			'permisos'=>$permisos,
    			'entities'=>$provedores
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
		
    
}
