<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Session\Session;

class InvitedController extends Controller
{
    /**
     * @Route("/received", name="Received")
     */
    public function showAction(Request $request)
    {
        $session = new Session();

        if(!$session->has('userName')){
            //$session->clear();
            return $this->redirectToRoute('login');
        }

        // replace this example code with whatever you need
        return $this->render('default/invited/list.html.twig', [
            'pageName' => 'Received Invitation',
            'name' => $session->get('userName'),
            'id' => $session->get('userId')
        ]);
    }
}
