<?php
namespace system\crmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
	public function loginAction(Request $request)
	{
		$authenticationUtils = $this->get('security.authentication_utils');
		
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
		return $this->render(
				'crmBundle:Security:login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $lastUsername,
						'error'         => $error,
				)
		);
	}
	public function loginCheckAction()
	{
		// this controller will not be executed,
		// as the route is handled by the Security system
		//return new Response('');
		return $this->redirectToRoute('login_route');
	}
}