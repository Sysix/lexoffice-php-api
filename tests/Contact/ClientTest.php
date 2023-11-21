<?php

namespace Clicksports\LexOffice\Tests\Contact;

use Clicksports\LexOffice\Contact\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{
    public function testGenerateUrl()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['generateUrl']
        );

        $this->assertEquals(
            'contacts?page=0&size=100&direction=ASC&property=name',
            $stub->generateUrl(0)
        );
    }

    public function testCreate()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['create']
        );

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGet()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['get']
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testUpdate()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['update']
        );

        $response = $stub->update('resource-id', []);

        $this->assertEquals('body', $response->getBody()->__toString());
    }
}
