<?php

namespace Tests\src\Traits;

use CacheResponseTrait;
use Clicksports\LexOffice\Api;
use Clicksports\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Tests\TestClient;

class CacheResponseTraitTest extends TestClient
{

    /**
     * @return FilesystemAdapter
     */
    public function getCacheInterface()
    {
        return new FilesystemAdapter(
            'lexoffice',
            3600,
            __DIR__ . '/../cache'
        );
    }

    public function testCacheExceptions()
    {
        $this->expectException(CacheException::class);

        $stub = $this->createApiMockObject(
            new Response(),
            ['setCacheResponse']
        );

        $stub->newRequest('GET', '/');
        $stub->setCacheResponse($stub->request, new Response());
    }

    /**
     * @return Api|MockObject
     */
    public function testSetCacheInterface()
    {
        $stub = $this->createApiMockObject(
            new Response(200, [], '{"cache": true}'),
            ['setCacheInterface', 'setCacheResponse', 'getCacheResponse']
        );

        $stub->setCacheInterface($this->getCacheInterface());

        $this->assertTrue(true);

        return $stub;
    }

    /**
     * @depends testSetCacheInterface
     * @param Api|MockObject $stub
     * @throws \Clicksports\LexOffice\Exceptions\CacheException
     * @throws \Clicksports\LexOffice\Exceptions\LexOfficeApiException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testGetCacheResponse($stub)
    {
        $cacheInterface = $this->getCacheInterface();
        $cacheKey = 'lex-office--v1--';

        $stub->newRequest('GET', '/');

        // execute response "curl" with caching in background
        $response = $stub->getResponse();

        $this->assertEquals(
            $this->transformToString($response),
            $this->transformToString($stub->getCacheResponse($stub->request))
        );

        $this->assertEquals(
            '{"status":200,"headers":[],"body":"{\"cache\": true}","version":"1.1","reason":"OK"}',
            $cacheInterface->getItem($cacheKey)->get()
        );

        // remove cache
        $cacheInterface->deleteItem($cacheKey);
    }

    /**
     * @depends testSetCacheInterface
     * @param Api|MockObject $stub
     * @throws \Clicksports\LexOffice\Exceptions\CacheException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testSetCacheResponse($stub)
    {
        $cacheInterface = $this->getCacheInterface();
        $cacheKey = 'lex-office--v1--';

        $stub->newRequest('GET', '/');

        $fakeResponse = new Response(200, [], 'fake');

        $stub->setCacheResponse($stub->request, $fakeResponse);

        $this->assertEquals(
            $cacheInterface->getItem($cacheKey)->get(),
            $this->transformToString($fakeResponse)
        );

        // remove cache
        $cacheInterface->deleteItem($cacheKey);

        // test on post
        $stub->setCacheResponse(new Request('POST', '/'), $fakeResponse);
        $this->assertNull($cacheInterface->getItem($cacheKey)->get());

        // test on put
        $stub->setCacheResponse(new Request('PUT', '/'), $fakeResponse);
        $this->assertNull($cacheInterface->getItem($cacheKey)->get());

        // test on delete
        $stub->setCacheResponse(new Request('DELETE', '/'), $fakeResponse);
        $this->assertNull($cacheInterface->getItem($cacheKey)->get());
    }

    protected function transformToString(ResponseInterface $response)
    {
        $obj = new stdClass();
        $obj->status = $response->getStatusCode();
        $obj->headers = $response->getHeaders();
        $obj->body = $response->getBody()->__toString();
        $obj->version = $response->getProtocolVersion();
        $obj->reason = $response->getReasonPhrase();

        return json_encode($obj);
    }
}