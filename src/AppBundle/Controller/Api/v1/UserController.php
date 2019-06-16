<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/* List of API: 
- Create User
- Login
*/

class UserController extends Controller
{
	/**
     * @Route("/api/v1/createUser")
     * @Method("POST")
     */
    public function createUser(Request $request) {
    	$name = $request->query->get('name');
        $username = $request->query->get('username');
        $password = $request->query->get('password');

        $data = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy(['username' => $username]);

	    if ($data) {
	        $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Data Exist'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
	    }else{
            $createData = new User();
            $createData->setName($name);
            $createData->setUsername($username);
            $createData->setPassword($password);

            $em = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($createData);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

            $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Success',
                'message' => 'Data Created'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }

    /**
     * @Route("/api/v1/login")
     * @Method("POST")
     */
    public function login(Request $request) {
        $username = $request->query->get('username');
        $password = $request->query->get('password');

        $data = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneBy([
            'username' => $username,
            'password' => $password
        ]);

        if ($data) {
            $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Success',
                'message' => 'Login'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }else{
            $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
    }
}