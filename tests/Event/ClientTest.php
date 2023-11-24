<?php

namespace Clicksports\LexOffice\Tests\Event;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Event\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{

    public function testCreate()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body')
        );

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGet()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body')
        );

        $stub->get('resource-id');
    }

    public function testGetAll()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{"content": [], "totalPages": 1}')
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}')
        );

        $stub->update('resource-id', []);
    }

    public function testDelete()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body')
        );

        $response = $stub->delete('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

}
