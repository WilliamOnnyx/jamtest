<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $session = new Session();

        if(!$session->has('userName')){
            //$session->clear();
            return $this->redirectToRoute('login');
        }

        // replace this example code with whatever you need
        return $this->render('default/home.html.twig', [
            'pageName' => 'Homepage',
            'name' => $session->get('userName')
        ]);
    }

    
}
