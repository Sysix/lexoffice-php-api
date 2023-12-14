<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Invoice;
use Sysix\LexOffice\Clients\VoucherList;
use Sysix\LexOffice\Tests\TestClient;

class InvoiceTest extends TestClient
{
    public function testCreate(): void
    {
        [$api, $stub] = $this->createClientMockObject(Invoice::class);

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/invoices',
            $api->request->getUri()->__toString()
        );
    }

    public function testCreateFinalized(): void
    {
        [$api, $stub] = $this->createClientMockObject(Invoice::class);

        $response = $stub->create([
            'version' => 0
        ], true);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/invoices?finalize=true',
            $api->request->getUri()->__toString()
        );
    }

    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(Invoice::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/invoices/resource-id',
            $api->request->getUri()->__toString()
        );
    }

    public function testPage(): void
    {
        $this->expectDeprecationV1Warning('getPage');

        [$api, $stub] = $this->createClientMockObject(Invoice::class);

        $response = $stub->getPage(0);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=invoice&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100',
            $api->request->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            Invoice::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=invoice&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100',
            $api->request->getUri()->__toString()
        );
    }

    public function testGetVoucherListClient(): void
    {
        [, $stub] = $this->createClientMockObject(Invoice::class);

        $client = $stub->getVoucherListClient();

        $this->assertInstanceOf(VoucherList::class, $client);
    }

    public function testDocument(): void
    {
        [$api, $stub] = $this->createClientMockObject(Invoice::class);

        $response = $stub->document('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/invoices/resource-id/document',
            $api->request->getUri()->__toString()
        );
    }

    public function testDocumentContent(): void
    {
        [$api, $stub] = $this->createClientMultiMockObject(
            Invoice::class,
            [
                new Response(200, ['Content-Type' => 'application/json'], '{"documentFileId": "fake-id"}'),
                new Response()
            ]
        );

        $response = $stub->document('resource-id', true);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/files/fake-id',
            $api->request->getUri()->__toString()
        );
    }

    public function testFailedDocumentContent(): void
    {
        [$api, $stub] = $this->createClientMultiMockObject(
            Invoice::class,
            [
                new Response(500),
                new Response()
            ]
        );

        $response = $stub->document('resource-id', true);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(500, $response->getStatusCode());
    }
}
