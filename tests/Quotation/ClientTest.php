<?php

namespace Clicksports\LexOffice\Tests\Quotation;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Quotation\Client;
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
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
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

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}')
        );

        $stub->update('resource-id', []);
    }

    public function testDocument()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{"documentFileId": "fake-id"}')
        );

        $response = $stub->document('resource-id');

        $this->assertEquals(
            '{"documentFileId": "fake-id"}',
            $response->getBody()->__toString()
        );

        $stub = $this->createClientMultiMockObject(
            Client::class,
            [
                new Response(200, [], '{"documentFileId": "fake-id"}'),
                new Response(200, [], '{}')
            ]
        );

        $response = $stub->document('resource-id', true);

        $this->assertEquals(
            '{}',
            $response->getBody()->__toString()
        );
    }
}
