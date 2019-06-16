<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Entity\Invitation;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*List of API:
- Send Invitation
- Change Status
- senderList -> The Sender can see a list of all invitations they have sent
- invitedList -> The Invited can see a list of all invitations they have received.
*/

class InvitationController extends Controller
{
	/**
     * @Route("/api/v1/sendInvitation")
     * @Method("POST")
     */
    public function sendInvitation(Request $request) {
    	$sender = $request->query->get('sender');
        $invited = $request->query->get('invited');

        $invitedCheck = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($invited);

        $senderCheck = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($sender);

        if (!$senderCheck) {
	        $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Sender Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
	    }

	    if (!$invitedCheck) {
	        $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Invitee Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
	    }

    	$check = $this->getDoctrine()
        ->getRepository(Invitation::class)
        ->findOneBy([
            'senderid' => $sender,
            'invitedid' => $invited
        ]);

        if($check){
	        $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Invitee already Invited'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
	    }else{
	    	$createData = new Invitation();
            $createData->setSender($senderCheck);
            $createData->setInvited($invitedCheck);
            $createData->setStatus(0);

            $em = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $em->persist($createData);

            // actually executes the queries (i.e. the INSERT query)
            $em->flush();

	    	$response = new Response();
            $response->setContent(json_encode([
                'status' => 'Success',
                'message' => 'Invitation Sent'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
	    }
    }

    /**
     * @Route("/api/v1/changeStatus/{id}")
     * @Method("PUT")
     */
    public function changeStatus(Request $request,$id){
    	$em = $this->getDoctrine()->getManager();

    	$data = $em
        ->getRepository(Invitation::class)
        ->find($id);

        if (!$data) {
        	$response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $data->setStatus($request->query->get('status'));
        $em->flush();

        $response = new Response();
        $response->setContent(json_encode([
            'status' => 'Success',
            'message' => 'Status Changed'
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }


    /**
     * @Route("/api/v1/senderList/{senderId}")
     * @Method("GET")
     */
    public function senderList($senderId){

    	$invitation = $this->getDoctrine()
        ->getRepository(Invitation::class)
        ->findOneBy(['senderid' => $senderId]);

        if (!$invitation) {
        	$response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $invitationRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Invitation');

        $user = $invitationRepository->senderList($senderId);

    	$response = new Response();
        $response->setContent(json_encode([
            'status' => 'Success',
            'message' => 'Data Found',
            'data' => $user
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/v1/invitedList/{invitedId}")
     * @Method("GET")
     */
    public function invitedList($invitedId){

    	$invitation = $this->getDoctrine()
        ->getRepository(Invitation::class)
        ->findOneBy(['invitedid' => $invitedId]);

        if (!$invitation) {
        	$response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $invitationRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Invitation');

        $user = $invitationRepository->invitedList($invitedId);

    	$response = new Response();
        $response->setContent(json_encode([
            'status' => 'Success',
            'message' => 'Data Found',
            'data' => $user
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/v1/invitationList/{id}")
     * @Method("GET")
     */
    public function invitationList($id){

        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);

        if (!$user) {
            $response = new Response();
            $response->setContent(json_encode([
                'status' => 'Failed',
                'message' => 'Data Not Found'
            ]));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $invitationRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:User');

        $user = $invitationRepository->invitationList($id);

        $response = new Response();
        $response->setContent(json_encode([
            'status' => 'Success',
            'message' => 'Data Found',
            'data' => $user
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}