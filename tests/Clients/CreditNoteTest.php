<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\CreditNote;
use Sysix\LexOffice\Clients\VoucherList;
use Sysix\LexOffice\Tests\TestClient;

class CreditNoteTest extends TestClient
{
    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/credit-notes/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testCreate(): void
    {
        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/credit-notes',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testCreateFinalized(): void
    {
        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->create([
            'version' => 0
        ], true);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/credit-notes?finalize=true',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testPursue(): void
    {
        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->pursue('resource-id', [
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/credit-notes?precedingSalesVoucherId=resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testPursueinalized(): void
    {
        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->pursue('resource-id', [
            'version' => 0
        ], true);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/credit-notes?precedingSalesVoucherId=resource-id&finalize=true',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetPage(): void
    {
        $this->expectDeprecationV1Warning('getPage');

        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->getPage(0);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=creditnote&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            CreditNote::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=creditnote&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetVoucherListClient(): void
    {
        [, $stub] = $this->createClientMockObject(CreditNote::class);

        $client = $stub->getVoucherListClient();

        $this->assertInstanceOf(VoucherList::class, $client);
    }

    public function testDocument(): void
    {
        [$api, $stub] = $this->createClientMockObject(CreditNote::class);

        $response = $stub->document('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/credit-notes/resource-id/document',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testDocumentContent(): void
    {
        [$api, $stub] = $this->createClientMultiMockObject(
            CreditNote::class,
            [
                new Response(200, ['Content-Type' => 'application/json'], '{"documentFileId": "fake-id"}'),
                new Response()
            ]
        );

        $response = $stub->document('resource-id', true);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/files/fake-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testFailedDocumentContent(): void
    {
        [$api, $stub] = $this->createClientMultiMockObject(
            CreditNote::class,
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
