<?php

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\DownPaymentInvoice;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class DownPaymentInvoiceTest extends TestClient
{
    public function testGetAll()
    {
        $stub = $this->createClientMockObject(
            DownPaymentInvoice::class,
            new Response(200, [], '{"content": [], "totalPages": 1}')
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testDocument()
    {
        $stub  = $this->createClientMockObject(
            DownPaymentInvoice::class,
            new Response(200, [], '{"documentFileId": "fake-id"}')
        );

        $response = $stub->document('resource-id');

        $this->assertEquals(
            '{"documentFileId": "fake-id"}',
            $response->getBody()->__toString()
        );

        $stub  = $this->createClientMultiMockObject(
            DownPaymentInvoice::class,
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
