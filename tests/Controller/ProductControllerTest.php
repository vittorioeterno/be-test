<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProducts(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/my-api/products');

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $response_data = json_decode($response->getContent(), true);

        $this->assertSame(true, isset($response_data["data"]));
        $this->assertSame(2, count($response_data["data"]));

    }


    public function testProduct(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/my-api/products?categoryId=2');

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());

        $response_data = json_decode($response->getContent(), true);

        $this->assertSame(true, isset($response_data["data"]));
        $this->assertSame(1, count($response_data["data"]));
        $this->assertSame(2, $response_data["data"][0]["id"]);

        var_dump($response_data);

    }
}
