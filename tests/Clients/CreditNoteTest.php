<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\CreditNote;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class CreditNoteTest extends TestClient
{
    public function testCreate()
    {
        $stub = $this->createClientMockObject(
            CreditNote::class,
            new Response(200, [], 'body'),
            ['create']
        );

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGetAll()
    {
        $stub = $this->createClientMockObject(
            CreditNote::class,
            new Response(200, [], '{"content": [], "totalPages": 1}'),
            ['getAll']
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testDocument()
    {
        $stub  = $this->createClientMockObject(
            CreditNote::class,
            new Response(200, [], '{"documentFileId": "fake-id"}'),
            ['document']
        );

        $response = $stub->document('resource-id');

        $this->assertEquals(
            '{"documentFileId": "fake-id"}',
            $response->getBody()->__toString()
        );

        $stub  = $this->createClientMultiMockObject(
            CreditNote::class,
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
