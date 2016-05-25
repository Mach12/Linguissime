<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{	
	/**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return array(
            array('/login'),
            array('/register')
        );
    }

    public function testLogin()
    {   
        $client = static::createClient();

    	$crawler = $client->request('GET', '/login');

    	$form = $crawler->selectButton('login')->form();
    	$crawler = $client->submit($form, array('_username' => 'eloxn@yahoo.com', '_password' => 'elonelon'));

    	$response = $client->followRedirect();
    	$this->assertEquals('http://localhost/' , $client->getRequest()->getUri()); 
    }

    public function testRegister() 
    {   
        $length = 10;
        $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

    	$client = static::createClient();
    	$crawler = $client->request('GET', '/register');

    	$form = $crawler->selectButton('register')->form();
    	$crawler = $client->submit($form, array('register[email]' => $randomString.'@yahoo.com', 'register[username]' => $randomString, 'register[plainPassword]' => 'antoinepassword'));

    	$response = $client->followRedirect();
    	$this->assertEquals('http://localhost/login' , $client->getRequest()->getUri());
    }

    public function testRegisterWithWrongValues()
    {
        $client = static::createClient();
    	$crawler = $client->request('GET', '/register');

    	$form = $crawler->selectButton('register')->form();
    	$crawler = $client->submit($form, array('register[email]' => 'wrong', 'register[username]' => '..', 'register[plainPassword]' => 'passxxxxxxxx'));

    	$this->assertGreaterThan(0, $crawler->filter('body:contains("This value is not a valid email address.")')->count());
        $this->assertGreaterThan(0, $crawler->filter('body:contains("This value is too short. It should have 4 characters or more.")')->count());
    }

    public function testRegisterWithNullValues()
    {
        $client = static::createClient();
    	$crawler = $client->request('GET', '/register');

    	$form = $crawler->selectButton('register')->form();

    	$crawler = $client->submit($form, array('register[email]' => 'test@yahoo.com', 'register[username]' => null, 'register[plainPassword]' => 'passxxxxxxxx'));
    	$this->assertEquals( 1, $crawler->filter('body:contains("This value should not be null.")')->count());

        $crawler = $client->submit($form, array('register[email]' => null, 'register[username]' => 'abcdefgh', 'register[plainPassword]' => 'passxxxxxxxx'));
        $this->assertEquals( 1, $crawler->filter('body:contains("This value should not be null.")')->count());
    }

    public function testChangeAccount()
    {   
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();
        $crawler = $client->submit($form, array('_username' => 'eloxn@yahoo.com', '_password' => 'elonelon'));

        $crawler = $client->request('GET', '/settings/account');

        $this->assertEquals('http://localhost/settings/account' , $client->getRequest()->getUri());

        $form = $crawler->selectButton('send')->form();
        $crawler = $client->submit($form, array('change_account[username]' => 'elon MUSK 1', 'change_account[email]' => 'eloxn@yahoo.com'));
    }

    public function testChangeAccountWithNullValues()
    {   
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();
        $crawler = $client->submit($form, array('_username' => 'eloxn@yahoo.com', '_password' => 'elonelon'));

        $crawler = $client->request('GET', '/settings/account');

        $this->assertEquals('http://localhost/settings/account' , $client->getRequest()->getUri());

        $form = $crawler->selectButton('send')->form();

        $crawler = $client->submit($form, array('change_account[username]' => null, 'change_account[email]' => 'eloxn@yahoo.com'));
        $this->assertEquals( 1, $crawler->filter('body:contains("This value should not be null.")')->count());

        $crawler = $client->submit($form, array('change_account[username]' => 'elon musk 1', 'change_account[email]' => null));
        $this->assertEquals( 1, $crawler->filter('body:contains("This value should not be null.")')->count());
    }

    public function testChangeAccountWithWrongValues()
    {   
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();
        $crawler = $client->submit($form, array('_username' => 'eloxn@yahoo.com', '_password' => 'elonelon'));

        $crawler = $client->request('GET', '/settings/account');

        $this->assertEquals('http://localhost/settings/account' , $client->getRequest()->getUri());

        $form = $crawler->selectButton('send')->form();

        $crawler = $client->submit($form, array('change_account[username]' => 'elon musk 1', 'change_account[email]' => 123));
        $this->assertEquals( 1, $crawler->filter('body:contains("This value is not a valid email address.")')->count());

        $crawler = $client->submit($form, array('change_account[username]' => 'ee', 'change_account[email]' => 'eloxn@yahoo.com'));
        $this->assertEquals( 1, $crawler->filter('body:contains("This value is too short. It should have 4 characters or more.")')->count());
    }
}
