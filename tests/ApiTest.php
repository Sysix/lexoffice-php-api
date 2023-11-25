<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use Sysix\LexOffice\Clients\Contact;
use Sysix\LexOffice\Clients\Country;
use Sysix\LexOffice\Clients\CreditNote;
use Sysix\LexOffice\Clients\DownPaymentInvoice;
use Sysix\LexOffice\Clients\Event;
use Sysix\LexOffice\Clients\File;
use Sysix\LexOffice\Clients\Invoice;
use Sysix\LexOffice\Clients\OrderConfirmation;
use Sysix\LexOffice\Clients\Payment;
use Sysix\LexOffice\Clients\PaymentCondition;
use Sysix\LexOffice\Clients\Profile;
use Sysix\LexOffice\Clients\PostingCategory;
use Sysix\LexOffice\Clients\Quotation;
use Sysix\LexOffice\Clients\Voucher;
use Sysix\LexOffice\Clients\VoucherList;
use Sysix\LexOffice\Clients\RecurringTemplate;
use GuzzleHttp\Psr7\Response;

class ApiTest extends TestClient
{
    public function createApiMockObject(Response $response)
    {
        $stub = parent::createApiMockObject($response);
        $stub->newRequest('GET', '/');

        return $stub;
    }

    public function testClients()
    {
        $stub = $this->createApiMockObject(new Response());

        $this->assertInstanceOf(Country::class, $stub->country());
        $this->assertInstanceOf(Contact::class, $stub->contact());
        $this->assertInstanceOf(Event::class, $stub->event());
        $this->assertInstanceOf(Invoice::class, $stub->invoice());
        $this->assertInstanceOf(DownPaymentInvoice::class, $stub->downPaymentInvoice());
        $this->assertInstanceOf(OrderConfirmation::class, $stub->orderConfirmation());
        $this->assertInstanceOf(Quotation::class, $stub->quotation());
        $this->assertInstanceOf(Voucher::class, $stub->voucher());
        $this->assertInstanceOf(VoucherList::class, $stub->voucherlist());
        $this->assertInstanceOf(Profile::class, $stub->profile());
        $this->assertInstanceOf(CreditNote::class, $stub->creditNote());
        $this->assertInstanceOf(Payment::class, $stub->payment());
        $this->assertInstanceOf(PaymentCondition::class, $stub->paymentCondition());
        $this->assertInstanceOf(File::class, $stub->file());
        $this->assertInstanceOf(RecurringTemplate::class, $stub->recurringTemplate());
        $this->assertInstanceOf(PostingCategory::class, $stub->postingCategory());
    }

    public function testApiUrl()
    {
        $stub = $this->createApiMockObject(
            new Response(200, [], 'post-content')
        );

        $this->assertStringStartsWith('api.lexoffice.io', $stub->request->getUri()->getHost());

        $stub->apiUrl = 'https://test.de';
        $stub->newRequest('POST', 'post-content');

        $this->assertStringStartsWith('test.de', $stub->request->getUri()->getHost());
    }

    public function testGetResponse()
    {
        $responseMock = new Response(200, [], 'response-body');
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
