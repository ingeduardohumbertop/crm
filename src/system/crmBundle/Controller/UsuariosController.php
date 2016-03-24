<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use system\crmBundle\Entity\Usuarios;
use system\crmBundle\Form\UsuariosType;
use Symfony\Component\HttpFoundation\JsonResponse;
use system\crmBundle\Entity\Permisos;
use system\crmBundle\Form\PermisosType;

class UsuariosController extends Controller
{
	public function indexAction(Request $request){
		$user = $this->getUser();
		$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
		if(!$permisos->getUsuariosModulo()){
			$this->get('session')->getFlashBag()->add('error','No tienes permisos para ver este modulo ');
			return $this->redirect($this->generateUrl('index'));
		}
		$usuarios = $this->getDoctrine()->getManager()
		->createQueryBuilder()
		->select('u')
		->from('crmBundle:Usuarios', 'u')
		->orderBy('u.fechaAlta', 'ASC')
		->getQuery()
		->getResult();
		

		return $this->render('crmBundle:Usuarios:index.html.twig',
				array ('mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'usuarios'),
						'entities'=>$usuarios,
						'permisos'=>$permisos
						
				));
	}
	
	public function handlerAction(Request $request, $idUsuario=0){
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$usuarioExistente = $em ->getRepository('crmBundle:Usuarios')->find($idUsuario);	
		//$permisosExistentes = $em ->getRepository('crmBundle:Permisos')->find($idUsuario);	
		$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
		if(!$usuarioExistente){
			if(!$permisos->getUsuariosAgregar()){
				$this->get('session')->getFlashBag()->add('error','No tienes permisos para agregar');
				return $this->redirectToRoute('usuariosIndex');
			}
			$header='Agregar Usuario';
			$nombre='';
			$apellidoP ='';
			$apellidoM= '';
			$display="display:none;";
			$usuarioNew=new Usuarios();
			$permisosEntity = new Permisos();
			
			$form = $this->createForm(new UsuariosType(), $usuarioNew );
			$formPermisos = $this->createForm( new PermisosType(), $permisosEntity);
			$form->handleRequest($request);
			$formPermisos->handleRequest($request);
				$now=new \DateTime();
				if ($form->isValid() && $formPermisos->isValid() ) {
					$usuarioNew
					->setFechaAlta($now)
					->setIsActive(true);
					$em->persist($usuarioNew);
					$em->flush();
					
					$permisosEntity
					->setIdUsuario($usuarioNew->getId());
					$em->persist($permisosEntity);
					$em->flush();
					
					$this->get('session')->getFlashBag()->add('mensaje','Se ha agregado el registro correctamente');
					return $this->redirect($this->generateUrl('usuariosEditar', array('idUsuario'=>$usuarioNew->getId())));
				}
		}else{
			$header='Editar Usuario';
			$display="";
			$nombre=$usuarioExistente->getNombre();
			$apellidoP =$usuarioExistente->getAPaterno();
			$apellidoM= $usuarioExistente->getAMaterno();
			if(!$permisos->getUsuariosEditar()){
				$this->get('session')->getFlashBag()->add('error','No tienes permisos para editar');
				return $this->redirectToRoute('usuariosIndex');
			}
			if($usuarioExistente->getId()!=$idUsuario){
				$this->get('session')->getFlashBag()->add('error','No existe este usuario con este id');
				return $this->redirectToRoute('usuariosIndex');
			}
			$permisosUsuario = $em->getRepository('crmBundle:Permisos')->findOneByIdUsuario($usuarioExistente->getId());
			$now=new \DateTime();
			$form = $this->createForm(new UsuariosType() , $usuarioExistente);
			$formPermisos = $this->createForm( new PermisosType(), $permisosUsuario);
			$form->handleRequest($request);
			$formPermisos->handleRequest($request);
			if ($form->isValid() &&  $formPermisos->isValid()) {
				$usuarioExistente
				->setFechaModificacion($now);
				$em->flush();//guarda usuarios y permisos
				$this->get('session')->getFlashBag()->add('mensaje','Se ha actualizado el usuario exitosamente');
				return $this->redirect($this->generateUrl('usuariosIndex', array()));
			
			
		}
		
		}
		return $this->render('crmBundle:Usuarios:agregar.html.twig',
				array ('mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'usuarios'),
						'header'=>$header,
						'form' => $form->createView(),
						'formPermisos' => $formPermisos->createView(),
						'permisos'=>$permisos,
						'idUsuario'=>$user->getId(),
						'display'=>$display,
						'nombre'=>$nombre,
						'apellidoP'=>$apellidoP,
						'apellidoM'=>$apellidoM,
						
				));
	}
	public function eliminarAction($idUsuario){
		$user= $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
		if(!$permisos->getUsuariosEliminar()){
			$this->get('session')->getFlashBag()->add('error','No Tienes los permisos para eliminar');
			return $this->redirectToRoute('usuariosIndex');
		}
	
		$usuario = $em ->getRepository('crmBundle:Usuarios')->find($idUsuario);
		$now=new \DateTime();
		$usuario
		->setIsActive(false)
		->setFechaBaja($now);
		$em->flush();
		
		$this->get('session')->getFlashBag()->add('mensaje','El Usuario se a dado de baja');
		return $this->redirectToRoute('usuariosIndex');
		
	}
	public function listFotoAction($idUsuario){
	
		$em = $this->getDoctrine()->getManager();
	
		$usuarios = $em->getRepository('crmBundle:Usuarios')->find($idUsuario);
		$files=array();
		if($usuarios->getFotoPath()!=''){
			$files[] = array(
					'name' => $usuarios->getNombre(),
					'size' => '0',
					'url'  => $usuarios->getFotoPath(),
					'thumbnailUrl' => $usuarios->getFotoPath(),
					'deleteUrl'   =>"/usuarios/eliminarFoto/".$idUsuario,
					'deleteType' => 'DELETE',
					'orden' => '1',
					'tipo' => 'foto',
					'idFotos'=> '1'
			);
		}
		
		$response = new JsonResponse();
	
		$response->setData(array(
				'files' => $files
		));
		return $response;
	}
}
