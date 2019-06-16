<?php

namespace Tests\AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/invitationList/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
		    $client->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		    ),
		    'the "Content-Type" header is "application/json"' // optional message shown on failure
		);

        $client1 = static::createClient();
		$crawler1 = $client1->request('GET', '/api/v1/invitedList/1');

        $this->assertEquals(200, $client1->getResponse()->getStatusCode());
        $this->assertTrue(
		    $client1->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		    ),
		    'the "Content-Type" header is "application/json"' // optional message shown on failure
		);

		$client2 = static::createClient();
		$crawler2 = $client2->request('GET', '/api/v1/senderList/1');

        $this->assertEquals(200, $client2->getResponse()->getStatusCode());
        $this->assertTrue(
		    $client2->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		    ),
		    'the "Content-Type" header is "application/json"' // optional message shown on failure
		);

		$client3 = static::createClient();
		$crawler3 = $client3->request('PUT', '/api/v1/changeStatus/1?status=4');

        $this->assertEquals(200, $client3->getResponse()->getStatusCode());
        $this->assertTrue(
		    $client3->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		    ),
		    'the "Content-Type" header is "application/json"' // optional message shown on failure
		);

		$client4 = static::createClient();
		$crawler4 = $client4->request('POST', '/api/v1/sendInvitation?sender=1&invited=7');

        $this->assertEquals(200, $client4->getResponse()->getStatusCode());
        $this->assertTrue(
		    $client4->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		    ),
		    'the "Content-Type" header is "application/json"' // optional message shown on failure
		);
    }
}
