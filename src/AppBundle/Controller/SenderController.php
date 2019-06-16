<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\Session;

class SenderController extends Controller
{
    /**
     * @Route("/invitation", name="Invitation")
     */
    public function showAction(Request $request)
    {
        $session = new Session();

        if(!$session->has('userName')){
            //$session->clear();
            return $this->redirectToRoute('login');
        }

        // replace this example code with whatever you need
        return $this->render('default/sender/list.html.twig', [
            'pageName' => 'Invitation',
            'name' => $session->get('userName'),
            'id' => $session->get('userId')
        ]);
    }
}
