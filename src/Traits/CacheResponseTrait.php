<?php

namespace Clicksports\LexOffice\Traits;

use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Utils;
use GuzzleHttp\Psr7\Response;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

trait CacheResponseTrait
{
    /**
     * @var CacheItemPoolInterface|null
     */
    protected ?CacheItemPoolInterface $cacheInterface = null;

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
     * @param RequestInterface $request
     * @return string
     */
    protected function getCacheName(RequestInterface $request): string
    {
        return 'lex-office-' . str_replace('/', '-', $request->getUri()->getPath()) . $request->getUri()->getQuery();
    }


    /**
     * @param RequestInterface $request
     * @return Response|null
     * @throws CacheException
     */
    public function getCacheResponse(RequestInterface $request): ?Response
    {
        $cacheName = $this->getCacheName($request);

        try {
            if ($request->getMethod() == 'GET') {
                $cache = $this->cacheInterface->getItem($cacheName);

                if ($cache && $cache->isHit()) {
                    $cache = Utils::jsonDecode($cache->get());

                    return new Response(
                        $cache->status,
                        (array)$cache->headers,
                        Utils::streamFor($cache->body),
                        $cache->version,
                        $cache->reason
                    );
                }
            }
        } catch (InvalidArgumentException $exception) {
            throw new CacheException(
                'could not load cache response from request' . $request->getUri()->getPath(),
                $exception->getCode(),
                $exception
            );
        }

        return null;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return $this
     * @throws CacheException
     */
    public function setCacheResponse(RequestInterface $request, ResponseInterface $response): self
    {
        if ($request->getMethod() != 'GET') {
            return $this;
        }

        if (!$this->cacheInterface) {
            throw new CacheException('response could not be cached, cacheInterface is not defined');
        }

        try {
            $cacheName = $this->getCacheName($request);

            $cache = new stdClass();
            $cache->status = $response->getStatusCode();
            $cache->headers = $response->getHeaders();
            $cache->body = $response->getBody()->__toString();
            $cache->version = $response->getProtocolVersion();
            $cache->reason = $response->getReasonPhrase();

            $item = $this->cacheInterface->getItem($cacheName);
            $item->set(Utils::jsonEncode($cache));

            $this->cacheInterface->save($item);
        } catch (InvalidArgumentException $exception) {
            throw new CacheException(
                'response could not set cache for request ' . $request->getUri()->getPath(),
                $exception->getCode(),
                $exception
            );
        }

        return $this;
    }
}