<?php

// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
	/**
     * @Route("/login", name="login")
     */
    public function loginAction($last_username=null,$error=null)
    {
    	$session = new Session();

    	if($session->has('userName')){
    		//$session->clear();
    		return $this->redirectToRoute('homepage');
    	}

	    return $this->render('auth/login.html.twig', [
	        'last_username' => $last_username,
	        'error'         => $error,
	    ]);
    }

    /**
     * @Route("/auth", name="auth")
     */
    public function auth(Request $request)
    {	
    	$session = new Session();

    	if($session->has('userName')){
    		return $this->redirectToRoute('homepage');
    	}

    	$username = $request->get('_username');
    	$password = $request->get('_password');

    	$data = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy([
        	'username' => $username,
        	'password' => $password
        ]);

        if(!$data){
        	return $this->loginAction($username,'Data Not Found!');
        }else{
        	
			$session->set('userId', $data->getId());
			$session->set('userName', $data->getName());

        	return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    	$session = new Session();
    	
    	$session->clear();

    	return $this->redirectToRoute('login');
    }
}