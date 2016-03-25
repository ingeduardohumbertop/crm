<?php

//hola liz esta es una prueva para ver que si hayas resibido la actualizacion de hace un segundo 
//si tu haces una actualizacion o algo si esta bien le das comit y escribes lo que hiciste y en que parte 
// despues para actualizar haces lo que yo hize le das en team uy pull y recibiras actualizaciones q hize yo 
namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use system\crmBundle\Entity\Clientes;
use system\crmBundle\Form\ClientesType;


class ClientesController extends Controller
{
    public function indexAction(){
    	$user = $this->getUser();
    	$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
    	if(!$permisos->getModuloClientes() ){
    		$this->get('session')->getFlashBag()->add('error','No tienes permisos para ver este modulo ');
    		return $this->redirect($this->generateUrl('index'));
    	}
    	$clientes = $this->getDoctrine()->getManager()
    	->createQueryBuilder()
    	->select('c')
    	->from('crmBundle:Clientes', 'c')
    	->orderBy('c.id', 'DESC')
    	->getQuery()
    	->getResult();
    	
    	return $this->render('crmBundle:Clientes:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'clientes'),
    			'entities'=>$clientes,
    			'permisos'=>$permisos
    	));
    		
    }
    public function handlerAction(Request $request,  $idCliente=0){
    	$user= $this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	$em =$this->getDoctrine()->getManager();
    	$clientesExistente= $em->getRepository('crmBundle:Clientes')->find($idCliente);
    	if (!$clientesExistente){
    		if(!$permisos->getClientesAgregar()){
    			$this->get('session')->getFlashBag()->add('error','No tienes permisos para agregar');
    			return $this->redirectToRoute('ClientesIndex');
    		}
    		$header='Agregar Cliente';
    		$nombre='';
    		$apellidoP='';
    		$apellidoM='';
    		$clienteNew =new Clientes();
    		$form =$this->createForm(new ClientesType() , $clienteNew);
    		$form->handleRequest($request);
    		date_default_timezone_set('America/Mexico_City');
    		$now = new \DateTime();
    		if($form->isValid()){
    			$clienteNew
    			->setFechaCreacion($now)
    			->setIdUsuarioCreador($user->getId());
    			$em->persist($clienteNew);
    			$em->flush();
    			$this->get('session')->getFlashBag()->add('mensaje','Se a agregado el registro correctamente');
    			return $this->redirect($this->generateUrl('ClientesEditar', array('idCliente'=>$clienteNew->getId())));
    		}
    	}else {
    		$header='Editar Cliente';
    		$nombre = $clientesExistente->getNombre();
    		$apellidoP=$clientesExistente->getApellidoP();
    		$apellidoM=$clientesExistente->getApellidoM();
    		if(!$permisos->getClientesEditar()){
    			$this->get('session')->getFlashBag()->add('error','No tienes permisos para editar');
    			return $this->redirectToRoute('ClientesIndex');
    		}
    		if($clientesExistente->getId()!=$idCliente){
    			$this->get('session')->getFlashBag()->add('error','No existe este provedor con este id');
    			return $this->redirectToRoute('ClientesIndex');
    		}

    		$form=$this->createForm(new ClientesType(), $clientesExistente);
    		$form->handleRequest($request);
    		
    		$now = new \DateTime();
    		if($form->isValid()){
    			
    			
    			$em->flush();
    			$this->get('session')->getFlashBag()->add('mensaje','Se ha actualizado los datos correctamente');
    			return $this->redirect($this->generateUrl('ClientesIndex', array()));
    		}
    
    	}
    	return $this->render('crmBundle:Clientes:agregar.html.twig',
    			array ('mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'mauinaria'),
    					'header'=>$header,
    					'form' => $form->createView(),
    					'permisos'=>$permisos,
    					'idUsuario'=>$user->getId(),
    					'nombre'=>$nombre,
    					'apellidoP'=>$apellidoP,
    					'apellidoM'=>$apellidoM
    
    			));
    }
		
    
}
