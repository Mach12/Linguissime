<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpFoundation\Response;

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
     * test Register
     */
    public function testRegister()
    {
        $data = array(
            'register[username]' => 'blablabla',
            'register[email]' => 'blablabla@yahoo.com',
            'register[plainPassword]' => 'blablablabla',
        );

        $this->client->request('POST', '/register', $data);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * test Register
     */
    public function testRegisterFailure()
    {
        $data = array(
            'register[username]' => 'test',
            'register[email]' => null,
            'register[plainPassword]' => 'antoineantoine',
        );

        $this->client->request('POST', '/register', $data);
        $this->assertFalse($this->client->getResponse()->isSuccessful());

        $data = array(
            'register[username]' => 'antoineantoine',
            'register[email]' => 'wrong email !',
            'register[plainPassword]' => 'antoineantoine'
        );

        $this->client->request('POST', '/register', $data);
        $this->assertFalse($this->client->getResponse()->isSuccessful());
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

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);


        $client = static::createClient();

        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('GET',
            '/api/user/dashboard',
            array(),    
            array(),    
            array());

        $this->assertTrue($client->getResponse()->isSuccessful());

        $client = static::createClient();

        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('GET',
            '/api/user/badges',
            array(),    
            array(),    
            array());

        $this->assertTrue($client->getResponse()->isSuccessful());

        /*

        $data = array(
            'change_password[oldPassword]' => 'testtest',
            'change_password[newPassword]' => 'testtest',
        );

        $client = static::createClient();

        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('POST', '/api/user/settings/password', $data);

        $this->assertTrue($client->getResponse()->isSuccessful()); */

    }

}
