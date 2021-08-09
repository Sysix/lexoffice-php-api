<?php declare(strict_types=1);

namespace Clicksports\LexOffice;

use Clicksports\LexOffice\Clients\Contact;
use Clicksports\LexOffice\Clients\Country;
use Clicksports\LexOffice\Clients\CreditNote;
use Clicksports\LexOffice\Clients\DownPaymentInvoice;
use Clicksports\LexOffice\Clients\Event;
use Clicksports\LexOffice\Clients\File;
use Clicksports\LexOffice\Clients\Invoice;
use Clicksports\LexOffice\Clients\OrderConfirmation;
use Clicksports\LexOffice\Clients\Payment;
use Clicksports\LexOffice\Clients\PaymentCondition;
use Clicksports\LexOffice\Clients\Profile;
use Clicksports\LexOffice\PostingCategory\Client as PostingCategoryClient;
use Clicksports\LexOffice\Clients\Quotation;
use Clicksports\LexOffice\Clients\Voucher;
use Clicksports\LexOffice\Clients\VoucherList;
use Clicksports\LexOffice\Traits\CacheResponseTrait;
use Clicksports\LexOffice\RecurringTemplate\Client as RecurringTemplateClient;
use Clicksports\LexOffice\Voucher\Client as VoucherClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Api
{
    use CacheResponseTrait;

    /**
     * the library version
     */
    public const VERSION = "0.14.1";

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
    public function newRequest(string $method, string $resource, $headers = []): self
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
    public function setRequest(RequestInterface $request)
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
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getResponse()
    {
        $cache = null;
        if ($this->cacheInterface) {
            $response = $cache = $this->getCacheResponse($this->request);
        }

        // when no cacheInterface is set or the cache is invalid
        if (!isset($response)) {
            try {
                $response = $this->client->send($this->request);
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

        // set cache response when cache is invalid
        if ($this->cacheInterface && !$cache) {
            $this->setCacheResponse($this->request, $response);
        }

        return $response;
    }

    /**
     * @return Contact
     */
    public function contact()
    {
        return new Contact($this);
    }

    /**
     * @return Country
     */
    public function country()
    {
        return new Country($this);
    }

    /**
     * @return Event
     */
    public function event()
    {
        return new Event($this);
    }

    /**
     * @return Invoice
     */
    public function invoice()
    {
        return new Invoice($this);
    }

    /**
     * @return DownPaymentInvoice
     */
    public function downPaymentInvoice()
    {
        return new DownPaymentInvoice($this);
    }

    /**
     * @return OrderConfirmation
     */
    public function orderConfirmation()
    {
        return new OrderConfirmation($this);
    }

    /**
     * @return Payment
     */
    public function payment()
    {
        return new Payment($this);
    }

    /**
     * @return PaymentCondition
     */
    public function paymentCondition()
    {
        return new PaymentCondition($this);
    }

    /**
     * @return CreditNote
     */
    public function creditNote()
    {
        return new CreditNote($this);
    }

    /**
     * @return Quotation
     */
    public function quotation()
    {
        return new Quotation($this);
    }

    /**
     * @return Voucher
     */
    public function voucher()
    {
        return new Voucher($this);
    }

    /**
     * @return RecurringTemplateClient
     */
    public function recurringTemplate()
    {
        return new RecurringTemplateClient($this);
    }

    /**
     * @return VoucherList
     */
    public function voucherlist()
    {
        return new VoucherList($this);
    }

    /**
     * @return Profile
     */
    public function profile()
    {
        return new Profile($this);
    }

    /**
     * @return PostingCategoryClient
     */
    public function postingCategory()
    {
        return new PostingCategoryClient($this);
    }

    /**
     * @return File
     */
    public function file()
    {
        return new File($this);
    }
}
