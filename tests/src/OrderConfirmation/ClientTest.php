<?php

namespace Tests\Src\OrderConfirmation;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\OrderConfirmation\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestClient;

class ClientTest extends TestClient
{

    public function testCreate()
    {
        $stub  = $this->createClientMockObject(
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
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['get']
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGetAll()
    {
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{"content": [], "totalPages": 1}'),
            ['getAll']
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['update']
        );

        $stub->update('resource-id', []);
    }

    public function testDocument()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['document']
        );

        $stub->document('resource-id');
    }
}
