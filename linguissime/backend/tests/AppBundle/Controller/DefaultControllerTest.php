<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{   

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsNotFound($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isNotFound());
    }	

    public function urlProvider()
    {
        return array(
            array('/contact/api'),
            array('/register/api'),
        );
    }

    public function test()
    {
        $client = static::CreateClient();

        $crawler = $client->request('POST', '/contact/api', 
        array(),
        array(),
        array(
            'HTTP_X-Requested-With' => 'XMLHttpRequest',
            'CONTENT_TYPE' => 'application/json',
        ),
        '{"email":"test@yahoo.com", "subject":"testtest","content": "testtest"}');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }   

}
