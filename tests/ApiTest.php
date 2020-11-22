<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests;

use Clicksports\LexOffice\Clients\Contact;
use Clicksports\LexOffice\Clients\CreditNote;
use Clicksports\LexOffice\Clients\Event;
use Clicksports\LexOffice\Clients\File;
use Clicksports\LexOffice\Clients\Invoice;
use Clicksports\LexOffice\Clients\OrderConfirmation;
use Clicksports\LexOffice\Clients\Profile;
use Clicksports\LexOffice\Clients\Quotation;
use Clicksports\LexOffice\Clients\Voucher;
use Clicksports\LexOffice\Clients\VoucherList;
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

        $this->assertInstanceOf(Contact::class, $stub->contact());
        $this->assertInstanceOf(Event::class, $stub->event());
        $this->assertInstanceOf(Invoice::class, $stub->invoice());
        $this->assertInstanceOf(OrderConfirmation::class, $stub->orderConfirmation());
        $this->assertInstanceOf(Quotation::class, $stub->quotation());
        $this->assertInstanceOf(Voucher::class, $stub->voucher());
        $this->assertInstanceOf(VoucherList::class, $stub->voucherlist());
        $this->assertInstanceOf(Profile::class, $stub->profile());
        $this->assertInstanceOf(CreditNote::class, $stub->creditNote());
        $this->assertInstanceOf(File::class, $stub->file());
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
