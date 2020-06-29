<?php

namespace Clicksports\LexOffice;

use Clicksports\LexOffice\Contact\Client as ContactClient;
use Clicksports\LexOffice\CreditNote\Client as CreditNoteClient;
use Clicksports\LexOffice\Event\Client as EventClient;
use Clicksports\LexOffice\Invoice\Client as InvoiceClient;
use Clicksports\LexOffice\OrderConfirmation\Client as OrderConfirmationClient;
use Clicksports\LexOffice\Profile\Client as ProfileClient;
use Clicksports\LexOffice\Quotation\Client as QuotationClient;
use Clicksports\LexOffice\Traits\CacheResponseTrait;
use Clicksports\LexOffice\Voucher\Client as VoucherClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Api
{
    use CacheResponseTrait;

    /**
     * the library version
     */
    public const VERSION = "0.10.0";

    /**
     * the lex-office api url
     *
     * @var string $apiUrl
     */
    protected string $apiUrl = 'https://api.lexoffice.io';

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
     * @var Request|null $request
     */
    public ?Request $request = null;

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
     * @param $method
     * @param $resource
     * @param array $headers
     * @return $this
     */
    public function newRequest($method, $resource, $headers = []): self
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


        if (in_array($request->getMethod(), ['POST', 'PUT'])) {
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
        if (!isset($response) || !$response) {
            try {
                $response = $this->client->send($this->request);
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
     * @return ContactClient
     */
    public function contact()
    {
        return new ContactClient($this);
    }

    /**
     * @return EventClient
     */
    public function event()
    {
        return new EventClient($this);
    }

    /**
     * @return InvoiceClient
     */
    public function invoice()
    {
        return new InvoiceClient($this);
    }

    /**
     * @return OrderConfirmationClient
     */
    public function orderConfirmation()
    {
        return new OrderConfirmationClient($this);
    }

    /**
     * @return CreditNoteClient
     */
    public function creditNote()
    {
        return new CreditNoteClient($this);
    }

    /**
     * @return QuotationClient
     */
    public function quotation()
    {
        return new QuotationClient($this);
    }

    /**
     * @return VoucherClient
     */
    public function voucher()
    {
        return new VoucherClient($this);
    }

    /**
     * @return VoucherlistClient
     */
    public function voucherlist()
    {
        return new VoucherlistClient($this);
    }

    /**
     * @return ProfileClient
     */
    public function profile()
    {
        return new ProfileClient($this);
    }
}
