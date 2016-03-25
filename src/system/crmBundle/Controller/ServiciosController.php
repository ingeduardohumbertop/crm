<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use system\crmBundle\Entity\Permisos;
use system\crmBundle\Entity\Usuarios;

class ServiciosController extends Controller
{
	private $doctrine;
	public function __construct($doctrine=NULL)
	{
		$this->doctrine = $doctrine;
	}
	public function getMainMenu($user,$menu){
		$permisos = $this->getPermisos($user);
		$menuTop='';
		$menuHome='';
		$menuOpciones='';
		$menuInventario='';
		$menuObras='';
		
		if($permisos->getModuloInventario()){
			$menuProvedores='';
			$menuMaquinaria='';
			if ($menu=='provedores') {$menuClass= 'active'; $menuTop='active';} else $menuClass='';
			if($permisos->getProvedoresModulo()){
				$menuProvedores= "<li $menuClass ><a href='/provedores'>Provedores</a></li>";
			}
			if($permisos->getMaquinariaModulo()){
				$menuMaquinaria= "<li $menuClass ><a href='/maquinaria'>Maquinaria</a></li>";
			}
			$menuInventario =
			"<li class='dropdown $menuTop'>
			<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Inventario<span class='caret'></span></a>
			<ul class='dropdown-menu'>
			$menuProvedores
			$menuMaquinaria
			</ul>
			</li>";
		}
		
		if($permisos->getModuloOpciones()){
			$menuUsuarios='';
			if ($menu=='usuarios') {$menuClass= 'active'; $menuTop='active';} else $menuClass='';
			if($permisos->getUsuariosModulo()){
				$menuUsuarios= "<li $menuClass ><a href='/usuarios'>Usuarios</a></li>";
			}
		$menuOpciones = 
		"<li class='dropdown $menuTop'>
			<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Opciones<span class='caret'></span></a>
			<ul class='dropdown-menu'>
				$menuUsuarios
			</ul>
		</li>";
		}
		
			$menuClientes='';
		if($permisos->getModuloClientes()){
			if ($menu=='clientes') {$menuClass= 'active'; $menuTop='active';} else $menuClass='';
				$menuClientes= "<li $menuClass ><a href='/clientes'>Alta o Modificacion</a></li>";
				
			$menuClientes =
			"<li class='dropdown $menuTop'>
			<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Clientes<span class='caret'></span></a>
			<ul class='dropdown-menu'>
			$menuClientes
			</ul>
			</li>";
		}
		
			$menuObras='';
		if($permisos->getObrasModulo()){
			$menuObraAlta='';
			if ($menu=='obras') {$menuClass= 'active'; $menuTop='active';} else $menuClass='';
				$menuObraAlta= "<li $menuClass ><a href='/obras'>Alta o Modificacion</a></li>";
				
			$menuObras =
			"<li class='dropdown $menuTop'>
			<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Obras<span class='caret'></span></a>
			<ul class='dropdown-menu'>
			$menuObraAlta
			</ul>
			</li>";
		}

		$menuTop='';
		$mainMenu="
			<ul class='nav navbar-nav navbar-right'>
				<li><a href='/logout'>Salir</a></li>
			</ul>
			<ul class='nav navbar-nav navbar-left'>
				$menuHome
				$menuClientes
				$menuObras
				$menuInventario
				$menuOpciones
			</ul>";
		
		
		return $mainMenu;
	}
	public function getPermisos($user){
		//$permisos=$this->get('crm.servicios_controller')->getPermisos($user);
		$em = $this->doctrine->getManager();
		$usuario = $em->getRepository('crmBundle:Usuarios')->findOneBy(array('id' => $user->getid()));

		if(!$usuario->getIsActive()){
			return new Permisos();
		}else{
			$permisos = $em->getRepository('crmBundle:Permisos')->findOneBy(array('idUsuario' => $user->getId()));
			//echo $user->getPuesto();
			if(!$permisos){
				return new Permisos();
			}else{
				$now= new \DateTime();
				$user->setUltimaActividadSistema($now);
				$em->flush();
				return $permisos;
			}
		}
	}
}
