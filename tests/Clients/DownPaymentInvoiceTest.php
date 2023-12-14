<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Clients\DownPaymentInvoice;
use Sysix\LexOffice\Clients\VoucherList;
use Sysix\LexOffice\Tests\TestClient;

class DownPaymentInvoiceTest extends TestClient
{
    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(DownPaymentInvoice::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/down-payment-invoices/resource-id',
            $api->request->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            DownPaymentInvoice::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=downpaymentinvoice&voucherStatus=draft%2Copen%2Cpaid%2Cpaidoff%2Cvoided%2Caccepted%2Crejected&size=100',
            $api->request->getUri()->__toString()
        );
    }

    public function testGetVoucherListClient(): void
    {
        [, $stub] = $this->createClientMockObject(DownPaymentInvoice::class);

        $client = $stub->getVoucherListClient();

        $this->assertInstanceOf(VoucherList::class, $client);
    }

    public function testDocument(): void
    {
        [$api, $stub] = $this->createClientMockObject(DownPaymentInvoice::class);

        $response = $stub->document('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/down-payment-invoices/resource-id/document',
            $api->request->getUri()->__toString()
        );
    }

    public function testDocumentContent(): void
    {
        [$api, $stub] = $this->createClientMultiMockObject(
            DownPaymentInvoice::class,
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
            DownPaymentInvoice::class,
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
