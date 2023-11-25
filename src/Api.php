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
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Api
{
    /**
     * the lex-office api url
     *
     * @var string $apiUrl
     */
    public string $apiUrl = 'https://api.lexoffice.io';

    /**
     * the lex-office api version
     *
     * @var string $apiVersion
     */
    protected string $apiVersion = 'v1';

    /**
     * the lex-office api key
     *
     * @var string $apiKey
     */
    protected string $apiKey;

    /**
     * @var Client $client
     */
    protected Client $client;

    /**
     * @var RequestInterface $request
     */
    public RequestInterface $request;

    /**
     * LexOffice constructor.
     * @param string $apiKey
     * @param Client|null $client
     */
    public function __construct(string $apiKey, Client $client = null)
    {
        if (is_null($client)) {
            $client = new Client();
        }

        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @param string $method
     * @param string $resource
     * @param string[] $headers
     * @return $this
     */
    public function newRequest(string $method, string $resource, array $headers = []): self
    {
        $this->setRequest(
            new Request($method, $this->createApiUrl($resource), $headers)
        );

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return $this
     */
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

    /**
     * @param string $resource
     * @return string
     */
    protected function createApiUrl(string $resource): string
    {
        return $this->apiUrl . '/' . $this->apiVersion . '/' . $resource;
    }

    /**
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function getResponse(): ResponseInterface
    {
        try {
            return $this->client->send($this->request);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
            throw new LexOfficeApiException(
                $exception->getMessage(),
                $response ? $response->getStatusCode() : $exception->getCode(),
                $exception
            );
        } catch (GuzzleException $exception) {
            throw new LexOfficeApiException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @return Contact
     */
    public function contact(): Contact
    {
        return new Contact($this);
    }

    /**
     * @return Country
     */
    public function country(): Country
    {
        return new Country($this);
    }

    /**
     * @return Event
     */
    public function event(): Event
    {
        return new Event($this);
    }

    /**
     * @return Invoice
     */
    public function invoice(): Invoice
    {
        return new Invoice($this);
    }

    /**
     * @return DownPaymentInvoice
     */
    public function downPaymentInvoice(): DownPaymentInvoice
    {
        return new DownPaymentInvoice($this);
    }

    /**
     * @return OrderConfirmation
     */
    public function orderConfirmation(): OrderConfirmation
    {
        return new OrderConfirmation($this);
    }

    /**
     * @return Payment
     */
    public function payment(): Payment
    {
        return new Payment($this);
    }

    /**
     * @return PaymentCondition
     */
    public function paymentCondition(): PaymentCondition
    {
        return new PaymentCondition($this);
    }

    /**
     * @return CreditNote
     */
    public function creditNote(): CreditNote
    {
        return new CreditNote($this);
    }

    /**
     * @return Quotation
     */
    public function quotation(): Quotation
    {
        return new Quotation($this);
    }

    /**
     * @return Voucher
     */
    public function voucher(): Voucher
    {
        return new Voucher($this);
    }

    /**
     * @return RecurringTemplate
     */
    public function recurringTemplate(): RecurringTemplate
    {
        return new RecurringTemplate($this);
    }

    /**
     * @return VoucherList
     */
    public function voucherlist(): VoucherList
    {
        return new VoucherList($this);
    }

    /**
     * @return Profile
     */
    public function profile(): Profile
    {
        return new Profile($this);
    }

    /**
     * @return PostingCategory
     */
    public function postingCategory(): PostingCategory
    {
        return new PostingCategory($this);
    }

    /**
     * @return File
     */
    public function file(): File
    {
        return new File($this);
    }
}
