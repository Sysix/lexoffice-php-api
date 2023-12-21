<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Contact;
use Sysix\LexOffice\Clients\Country;
use Sysix\LexOffice\Clients\CreditNote;
use Sysix\LexOffice\Clients\DeliveryNote;
use Sysix\LexOffice\Clients\DownPaymentInvoice;
use Sysix\LexOffice\Clients\Event;
use Sysix\LexOffice\Clients\File;
use Sysix\LexOffice\Clients\Invoice;
use Sysix\LexOffice\Clients\OrderConfirmation;
use Sysix\LexOffice\Clients\Payment;
use Sysix\LexOffice\Clients\PaymentCondition;
use Sysix\LexOffice\Clients\PostingCategory;
use Sysix\LexOffice\Clients\Profile;
use Sysix\LexOffice\Clients\Quotation;
use Sysix\LexOffice\Clients\RecurringTemplate;
use Sysix\LexOffice\Clients\Voucher;
use Sysix\LexOffice\Clients\VoucherList;

class ApiTest extends TestClient
{
    public function createApiMockObject(Response $response)
    {
        $stub = parent::createApiMockObject($response);
        $stub->newRequest('GET', '/');

        return $stub;
    }

    public function testClients(): void
    {
        $stub = $this->createApiMockObject(new Response());

        $this->assertInstanceOf(Contact::class, $stub->contact());
        $this->assertInstanceOf(Country::class, $stub->country());
        $this->assertInstanceOf(CreditNote::class, $stub->creditNote());
        $this->assertInstanceOf(DeliveryNote::class, $stub->deliveryNote());
        $this->assertInstanceOf(DownPaymentInvoice::class, $stub->downPaymentInvoice());
        $this->assertInstanceOf(Event::class, $stub->event());
        $this->assertInstanceOf(File::class, $stub->file());
        $this->assertInstanceOf(Invoice::class, $stub->invoice());
        $this->assertInstanceOf(OrderConfirmation::class, $stub->orderConfirmation());
        $this->assertInstanceOf(Payment::class, $stub->payment());
        $this->assertInstanceOf(PaymentCondition::class, $stub->paymentCondition());
        $this->assertInstanceOf(PostingCategory::class, $stub->postingCategory());
        $this->assertInstanceOf(Profile::class, $stub->profile());
        $this->assertInstanceOf(Quotation::class, $stub->quotation());
        $this->assertInstanceOf(RecurringTemplate::class, $stub->recurringTemplate());
        $this->assertInstanceOf(Voucher::class, $stub->voucher());
        $this->assertInstanceOf(VoucherList::class, $stub->voucherlist());
    }

    public function testApiUrl(): void
    {
        $stub = $this->createApiMockObject(
            new Response(200, [], 'post-content')
        );

        $this->assertStringStartsWith('api.lexoffice.io', $stub->getRequest()->getUri()->getHost());

        $stub->apiUrl = 'https://test.de';
        $stub->newRequest('POST', 'post-content');

        $this->assertStringStartsWith('test.de', $stub->getRequest()->getUri()->getHost());
    }

    public function testGetSuccessResponse(): void
    {
        $stub = $this->createApiMockObject(new Response(200, [], 'response-body'));
        $response = $stub->getResponse();

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    /**
     * @see https://developers.lexoffice.io/docs/#error-codes
     */
    public function testGetFailedResponse(): void
    {
        $stub = $this->createApiMockObject(new Response(401, [], '{"message":"Unauthorized"}'));
        $response = $stub->getResponse();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $stub = $this->createApiMockObject(new Response(403, [], '{"message":"\'{accessToken}\' not a valid key=value pair (missing equal-sign) in Authorization header: \'Bearer {accessToken}\'."}'));
        $response = $stub->getResponse();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $stub = $this->createApiMockObject(new Response(500, [], '{"message":null}'));
        $response = $stub->getResponse();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $stub = $this->createApiMockObject(new Response(503, [], null));
        $response = $stub->getResponse();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $stub = $this->createApiMockObject(new Response(504, [], '{"message":"Endpoint request timed out}'));
        $response = $stub->getResponse();

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testRequestHeaders(): void
    {
        $api = $this->createApiMockObject(
            new Response(200, [], 'post-content')
        );

        $this->assertCount(1, $api->getRequest()->getHeader('Authorization'));
        $this->assertEquals('application/json', $api->getRequest()->getHeaderLine('Accept'));

        $api->newRequest('POST', '/');
        $this->assertEquals('application/json', $api->getRequest()->getHeaderLine('Content-Type'));

        $api->newRequest('PUT', '/');
        $this->assertEquals('application/json', $api->getRequest()->getHeaderLine('Content-Type'));
    }
}
