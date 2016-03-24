<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
		
    
}
