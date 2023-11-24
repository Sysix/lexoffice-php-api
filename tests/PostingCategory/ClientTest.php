<?php

namespace Clicksports\LexOffice\Tests\PostingCategory;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\PostingCategory\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{

    public function testCreate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body')
        );

        $stub->create([
            'version' => 0
        ]);
    }

    public function testGet()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body')
        );

        $stub->get('resource-id');
    }

    public function testGetAll()
    {
        $stub  = $this->createClientMockObject(
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
}
