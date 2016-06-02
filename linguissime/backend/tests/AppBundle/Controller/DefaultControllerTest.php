<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        $client->request('GET','/api/user/dashboard');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertNotEmpty($client->getResponse()->getContent());

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
        $this->assertNotEmpty($client->getResponse()->getContent());

        $data = array(
            'name' => 'Apprendre le français',
            'points' => '50',
        );

        $client = static::createClient();
        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('PUT', '/api/settings/stats', $data);

        $this->assertTrue($client->getResponse()->isSuccessful()); 
        $this->assertNotEmpty($client->getResponse()->getContent());

        $client = static::createClient();
        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('GET', '/api/user/stats');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertNotEmpty($client->getResponse()->getContent());

        $data = array(
            'points' => 200,
        );

        $client = static::createClient();
        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('PUT', '/api/settings/data', $data);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertNotEmpty($client->getResponse()->getContent());

        $photo = new UploadedFile(
            '/Users/grandiereantoine/Documents/test.png',
            'test.png',
            'image/png',
            123
        );

        $client = static::createClient();
        $client->setServerParameters([
            'HTTP_AUTHORIZATION' => 'Bearer ' . $response['token'],
            'CONTENT_TYPE' => 'application/json'
        ]);

        $client->request('PUT', '/api/user/settings/image', array('photo' => $photo));
        var_dump($client->getResponse()->getContent());

        $this->assertTrue($client->getResponse()->isSuccessful());


    }
}
