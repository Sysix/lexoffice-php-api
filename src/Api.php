<?php

namespace Clicksports\LexOffice;

use Clicksports\LexOffice\Contact\Client as ContactClient;
use Clicksports\LexOffice\Event\Client as EventClient;
use Clicksports\LexOffice\Invoice\Client as InvoiceClient;
use Clicksports\LexOffice\OrderConfirmation\Client as OrderConfirmationClient;
use Clicksports\LexOffice\Quotation\Client as QuotationClient;
use Clicksports\LexOffice\Voucher\Client as VoucherClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use function GuzzleHttp\Psr7\stream_for;
use function json_decode;

class Api
{
    /**
     * the library version
     */
    public const VERSION = "0.9.1";

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
     * @var CacheItemPoolInterface|null
     */
    protected ?CacheItemPoolInterface $cacheInterface = null;

    /**
     * LexOffice constructor.
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        $this->client = new Client();
    }

    /**
     * @param $method
     * @param $resource
     * @param array $headers
     * @return $this
     */
    public function newRequest($method, $resource, $headers = []): self
    {
        $headers = $headers + [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ];

        if (in_array($method, ['POST', 'PUT'])) {
            $headers['Content-Type'] = 'application/json';
        }

        $this->request = new Request(
            $method,
            $this->createApiUrl($resource),
            $headers
        );

        return $this;
    }

    /**
     * @param CacheItemPoolInterface $cache
     * @return $this
     */
    public function setCacheInterface(CacheItemPoolInterface $cache): self
    {
        $this->cacheInterface = $cache;

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
     * @return string
     */
    protected function getCacheName(): string
    {
        return 'lex-office-' . str_replace('/', '-', $this->request->getUri()->getPath());
    }

    /**
     * @return Response|null
     * @throws InvalidArgumentException
     */
    public function getCacheResponse(): ?Response
    {
        $cacheName = $this->getCacheName();

        if ($this->request->getMethod() == 'GET') {
            $cache = $this->cacheInterface->getItem($cacheName);

            if ($cache && $cache->isHit()) {
                $cache = json_decode($cache->get());

                return new Response(
                    $cache->status,
                    (array)$cache->headers,
                    stream_for($cache->body),
                    $cache->version,
                    $cache->reason
                );
            }
        }

        return null;
    }


    /**
     * @param ResponseInterface $response
     * @return $this
     * @throws CacheException
     */
    public function setCacheResponse(ResponseInterface $response): self
    {
        if ($this->request->getMethod() != 'GET') {
            return $this;
        }

        if (!$this->cacheInterface) {
            throw new CacheException('response could not be cached, cacheInterface is not defined');
        }

        try {
            $cacheName = $this->getCacheName();

            $cache = new stdClass();
            $cache->status = $response->getStatusCode();
            $cache->headers = $response->getHeaders();
            $cache->body = $response->getBody()->__toString();
            $cache->version = $response->getProtocolVersion();
            $cache->reason = $response->getReasonPhrase();

            $item = $this->cacheInterface->getItem($cacheName);
            $item->set(\GuzzleHttp\json_encode($cache));

            $this->cacheInterface->save($item);
        } catch (InvalidArgumentException $exception) {
            throw new CacheException(
                'response could not set cache for request ' . $this->request->getUri()->getPath(),
                $exception->getCode(),
                $exception
            );
        }

        return $this;
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
            try {
                $response = $cache = $this->getCacheResponse();
            } catch (InvalidArgumentException $exception) {
                throw new CacheException(
                    'could not load cache response from request ' . $this->request->getUri()->getPath(),
                    $exception->getCode(),
                    $exception->getPrevious()
                );
            }
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
            $this->setCacheResponse($response);
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
}
