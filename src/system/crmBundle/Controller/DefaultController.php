<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
	
	
    public function indexAction(){
    	$user = $this->getUser();
    	$permisos= $this->get('crm.servicios_controller')->getPermisos($user);
    	$obras = $this->getDoctrine()->getManager()
    	->createQueryBuilder()
    	->select("o.nombre, o.estadoObra,o.id,CONCAT(o.calle,' ', o.colonia,' ', o.municipio) as direccion")
    	->from('crmBundle:Obras', 'o')
    	->where("o.fechaCreacion >= :haceUnMes")
    	->setParameter('haceUnMes', new \DateTime('-30 day'))
    	->orderBy('o.fechaCreacion', 'ASC')
    	->getQuery()
    	->getResult();
    	
    
    	return $this->render('crmBundle:Default:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'usuarios'),
    			'entities'=>$obras,
    			'permisos'=>$permisos
    	));
    		
    }
    function numeroObrasAction(){
    	
    	$sql="SELECT COUNT(o.estadoObra)as cantidad ,o.estadoObra FROM obras as o
			GROUP BY o.estadoObra";
    	
    	$conn = $this->getDoctrine()->getManager()->getConnection();
    	$stmt = $conn->prepare($sql);
    	//$stmt->bindValue("fechaInicio", "$fechaInicio 00:00:00");
    	//$stmt->bindValue("fechaFin", "$fechaFin 23:59:59");
    	
    	$result=$stmt->execute();
    	$result= $stmt->fetchAll();
    	
    	$response = new JsonResponse();
    	$responseArray= array('resultados'=>$result);
    	$response->setData($responseArray);
    	return $response;
    	
    }
	
    
}
