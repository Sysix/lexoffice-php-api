<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\DeliveryNote;
use Sysix\LexOffice\Clients\VoucherList;
use Sysix\LexOffice\Tests\TestClient;

class DeliveryNoteTest extends TestClient
{
    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(DeliveryNote::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/delivery-notes/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testCreate(): void
    {
        [$api, $stub] = $this->createClientMockObject(DeliveryNote::class);

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/delivery-notes',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testPursue(): void
    {
        [$api, $stub] = $this->createClientMockObject(DeliveryNote::class);

        $response = $stub->pursue('resource-id', [
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/delivery-notes?precedingSalesVoucherId=resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetPage(): void
    {
        $this->expectDeprecationV1Warning('getPage');

        [$api, $stub] = $this->createClientMockObject(DeliveryNote::class);

        $response = $stub->getPage(0);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&voucherType=deliverynote&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100&sort=voucherNumber%2CDESC',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            DeliveryNote::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&voucherType=deliverynote&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100&sort=voucherNumber%2CDESC',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetVoucherListClient(): void
    {
        [, $stub] = $this->createClientMockObject(DeliveryNote::class);

        $client = $stub->getVoucherListClient();

        $this->assertInstanceOf(VoucherList::class, $client);
    }

    public function testDocument(): void
    {
        [$api, $stub] = $this->createClientMockObject(DeliveryNote::class);

        $response = $stub->document('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/delivery-notes/resource-id/document',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testDocumentContent(): void
    {
        [$api, $stub] = $this->createClientMultiMockObject(
            DeliveryNote::class,
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
            DeliveryNote::class,
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
