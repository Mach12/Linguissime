<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultControllerTest extends WebTestCase
{   

    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('POST', '/register/api');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testCreateSellerAction()
    {
        $client = static::createClient();
        $client->request(
            'POST', 
            '/contact/api',  
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"email":"test@yahoo.com", "subject":"testtest","content": "testtest"}'
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

}
