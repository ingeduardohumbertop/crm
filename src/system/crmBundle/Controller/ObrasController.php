<?php

namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ObrasController extends Controller
{
	
	
    public function indexAction(){
    	$user = $this->getUser();
    	
    	return $this->render('crmBundle:Obras:index.html.twig', array (
    			'mainMenu'=> $this->get('crm.servicios_controller')->getMainMenu($user,'obras'),
    	));
    		
    }
		
    
}
