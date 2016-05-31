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

         $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('%s %s', $this->authorizationHeaderPrefix, $response['token']));
        $client->request('GET', '/api/dashboard');

        $this->assertJsonResponse($client->getResponse(), 200, false);
    }

        /**
     * @param Response $response
     * @param int      $statusCode
     * @param bool     $checkValidJson
     */
    protected function assertJsonResponse(Response $response, $statusCode = 200, $checkValidJson = true)
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);

        if ($checkValidJson) {
            $decode = json_decode($response->getContent(), true);
            $this->assertTrue(
                ($decode !== null && $decode !== false),
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }


}
