<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Client;

class DefaultControllerTest extends WebTestCase
{  
    
    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * test login
     */
    public function testLoginFailure()
    {
        $data = array(
            '_username' => 'user',
            '_password' => 'userwrongpass',
        );

        $this->client->request('POST', '/api/login_check', $data);
        $this->assertFalse($this->client->getResponse()->isSuccessful());
    } 

        /**
     * test login
     */
    public function testLoginSuccess()
    {
        $data = array(
            '_username' => 'test@yahoo.com',
            '_password' => 'testtest',
        );

        $this->client->request('POST', '/api/login_check', $data);
        $this->client->getResponse()->isSuccessful();

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
    }


}
