<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests;

use GuzzleHttp\Psr7\Response;

class ApiTest extends TestClient
{
    public function createApiMockObject(Response $response, $methodExcept = [])
    {
        $stub = parent::createApiMockObject($response, $methodExcept);

        $stub->newRequest('GET', '/');

        return $stub;
    }

    public function testClients()
    {
        $stub = $this->createApiMockObject(
            new Response(),
            ['contact', 'event', 'invoice', 'orderConfirmation', 'quotation', 'voucher', 'voucherlist', 'profile', 'creditNote', 'file']
        );

        $this->assertInstanceOf(\Clicksports\LexOffice\Contact\Client::class, $stub->contact());
        $this->assertInstanceOf(\Clicksports\LexOffice\Event\Client::class, $stub->event());
        $this->assertInstanceOf(\Clicksports\LexOffice\Invoice\Client::class, $stub->invoice());
        $this->assertInstanceOf(\Clicksports\LexOffice\OrderConfirmation\Client::class, $stub->orderConfirmation());
        $this->assertInstanceOf(\Clicksports\LexOffice\Quotation\Client::class, $stub->quotation());
        $this->assertInstanceOf(\Clicksports\LexOffice\Voucher\Client::class, $stub->voucher());
        $this->assertInstanceOf(\Clicksports\LexOffice\Voucherlist\Client::class, $stub->voucherlist());
        $this->assertInstanceOf(\Clicksports\LexOffice\Profile\Client::class, $stub->profile());
        $this->assertInstanceOf(\Clicksports\LexOffice\CreditNote\Client::class, $stub->creditNote());
        $this->assertInstanceOf(\Clicksports\LexOffice\File\Client::class, $stub->file());
    }

    public function testGetResponse()
    {
        $responseMock =  new Response(200, [], 'response-body');
        $stub = $this->createApiMockObject($responseMock);

        $response = $stub->getResponse();

        $this->assertEquals($responseMock->getHeaders(), $response->getHeaders());
        $this->assertEquals($responseMock->getBody(), $response->getBody());
        $this->assertEquals($responseMock->getStatusCode(), $response->getStatusCode());
        $this->assertEquals($responseMock->getProtocolVersion(), $response->getProtocolVersion());
        $this->assertEquals($responseMock->getReasonPhrase(), $response->getReasonPhrase());
    }

    public function testRequestHeaders()
    {
        $stub = $this->createApiMockObject(
            new Response(200, [], 'post-content')
        );

        $this->assertCount(1, $stub->request->getHeader('Authorization'));
        $this->assertEquals('application/json', $stub->request->getHeaderLine('Accept'));

        $stub->newRequest('POST', '/');
        $this->assertEquals('application/json', $stub->request->getHeaderLine('Content-Type'));

        $stub->newRequest('PUT', '/');
        $this->assertEquals('application/json', $stub->request->getHeaderLine('Content-Type'));
    }
}
