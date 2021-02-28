<?php

namespace Clicksports\LexOffice\Tests\Payment;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Payment\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{

    public function testCreate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['create']
        );

        $stub->create([]);
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

    public function testGetAll()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['getAll']
        );

        $stub->getAll();
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
}
