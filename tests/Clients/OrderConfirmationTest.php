<?php

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\OrderConfirmation;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class OrderConfirmationTest extends TestClient
{

    public function testCreate(): void
    {
        $stub  = $this->createClientMockObject(
            OrderConfirmation::class,
            new Response(200, [], 'body')
        );

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGet(): void
    {
        $stub  = $this->createClientMockObject(
            OrderConfirmation::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGetAll(): void
    {
        $stub  = $this->createClientMockObject(
            OrderConfirmation::class,
            new Response(200, [], '{"content": [], "totalPages": 1}')
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testDocument(): void
    {
        $stub  = $this->createClientMockObject(
            OrderConfirmation::class,
            new Response(200, [], '{"documentFileId": "fake-id"}')
        );

        $response = $stub->document('resource-id');

        $this->assertEquals(
            '{"documentFileId": "fake-id"}',
            $response->getBody()->__toString()
        );

        $stub  = $this->createClientMultiMockObject(
            OrderConfirmation::class,
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
