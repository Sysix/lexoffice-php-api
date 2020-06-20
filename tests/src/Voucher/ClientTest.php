<?php

namespace Tests\Src\Voucher;

use Clicksports\LexOffice\Voucher\Client;
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
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['update']
        );

        $response = $stub->update('resource-id', []);

        $this->assertEquals('{}', $response->getBody()->__toString());
    }
}
