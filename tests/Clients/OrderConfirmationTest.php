<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\OrderConfirmation;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class OrderConfirmationTest extends TestClient
{

    public function testCreate()
    {
        $stub  = $this->createClientMockObject(
            OrderConfirmation::class,
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
            OrderConfirmation::class,
            new Response(200, [], 'body'),
            ['get']
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGetAll()
    {
        $stub = $this->createClientMultiMockObject(
            OrderConfirmation::class,
            [
                new Response(200, [], '{"content": ["a"], "totalPages": 1}'),
                new Response(200, [], '{"content": ["b"], "totalPages": 1}')
            ],
            ['getAll']
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": ["a"], "totalPages": 1}', $response->getBody()->__toString());

        $response = $stub->getAll(['open']);

        $this->assertEquals('{"content": ["b"], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testGetPage()
    {
        $stub = $this->createClientMultiMockObject(
            OrderConfirmation::class,
            [
                new Response(200, [], '{"content": [], "totalPages": 1}'),
            ],
            ['getPage']
        );

        $response = $stub->getPage(0);

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testDocument()
    {
        $stub  = $this->createClientMockObject(
            OrderConfirmation::class,
            new Response(200, [], '{"documentFileId": "fake-id"}'),
            ['document']
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