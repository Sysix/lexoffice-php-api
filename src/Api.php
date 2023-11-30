<?php declare(strict_types=1);

namespace Sysix\LexOffice;

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
use Sysix\LexOffice\Clients\PostingCategory;
use Sysix\LexOffice\Clients\Profile;
use Sysix\LexOffice\Clients\Quotation;
use Sysix\LexOffice\Clients\RecurringTemplate;
use Sysix\LexOffice\Clients\Voucher;
use Sysix\LexOffice\Clients\VoucherList;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SensitiveParameter;

class Api
{
    public string $apiUrl = 'https://api.lexoffice.io';

    protected string $apiVersion = 'v1';

    public RequestInterface $request;


    public function __construct(
        #[SensitiveParameter] protected string $apiKey, 
        protected ClientInterface $client
    )
    {
    }

    /**
     * @param string[] $headers
     */
    public function newRequest(string $method, string $resource, array $headers = []): self
    {
        $this->setRequest(
            new Request($method, $this->createApiUrl($resource), $headers)
        );

        return $this;
    }

    public function setRequest(RequestInterface $request): self
    {
        $request = $request
            ->withHeader('Authorization', 'Bearer ' . $this->apiKey)
            ->withHeader('Accept', 'application/json');


        if (!$request->hasHeader('Content-Type') && in_array($request->getMethod(), ['POST', 'PUT'])) {
            $request = $request->withHeader('Content-Type', 'application/json');
        }

        $this->request = $request;

        return $this;
    }

    protected function createApiUrl(string $resource): string
    {
        return $this->apiUrl . '/' . $this->apiVersion . '/' . $resource;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->client->sendRequest($this->request);
    }

    public function contact(): Contact
    {
        return new Contact($this);
    }

    public function country(): Country
    {
        return new Country($this);
    }

    public function event(): Event
    {
        return new Event($this);
    }

    public function invoice(): Invoice
    {
        return new Invoice($this);
    }

    public function downPaymentInvoice(): DownPaymentInvoice
    {
        return new DownPaymentInvoice($this);
    }

    public function orderConfirmation(): OrderConfirmation
    {
        return new OrderConfirmation($this);
    }

    public function payment(): Payment
    {
        return new Payment($this);
    }

    public function paymentCondition(): PaymentCondition
    {
        return new PaymentCondition($this);
    }

    public function creditNote(): CreditNote
    {
        return new CreditNote($this);
    }

    public function quotation(): Quotation
    {
        return new Quotation($this);
    }

    public function voucher(): Voucher
    {
        return new Voucher($this);
    }

    public function recurringTemplate(): RecurringTemplate
    {
        return new RecurringTemplate($this);
    }

    public function voucherlist(): VoucherList
    {
        return new VoucherList($this);
    }

    public function profile(): Profile
    {
        return new Profile($this);
    }

    public function postingCategory(): PostingCategory
    {
        return new PostingCategory($this);
    }

    public function file(): File
    {
        return new File($this);
    }
}
