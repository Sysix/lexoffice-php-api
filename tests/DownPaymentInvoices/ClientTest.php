<?php

namespace Clicksports\LexOffice\Tests\DownPaymentInvoices;

use Clicksports\LexOffice\DownPaymentInvoice\Client;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
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

        $stub->create([
            'version' => 0
        ]);
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['update']
        );

        $stub->update('resource-id', []);
    }

    public function testGetAll()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{"content": [], "totalPages": 1}'),
            ['getAll']
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testDocument()
    {
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{"documentFileId": "fake-id"}'),
            ['document']
        );

        $response = $stub->document('resource-id');

        $this->assertEquals(
            '{"documentFileId": "fake-id"}',
            $response->getBody()->__toString()
        );

        $stub  = $this->createClientMultiMockObject(
            Client::class,
            [
                new Response(200, [], '{"documentFileId": "fake-id"}'),
                new Response(200, [], '{}')
            ],
            ['document']
        );

        $response = $stub->document('resource-id', true);

        $this->assertEquals(
            '{}',
            $response->getBody()->__toString()
        );
    }
}
