<?php

namespace Tests\Src;

use Clicksports\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Tests\TestClient;

class ApiTest extends TestClient
{
    public function createApiMockObject(Response $response, $methodExcept = [])
    {
        $stub = parent::createApiMockObject($response, $methodExcept);

        /** @noinspection PhpUndefinedMethodInspection */
        $stub->newRequest('GET', '/');

        return $stub;
    }

    public function testClients()
    {
        $stub = $this->createApiMockObject(
            new Response(),
            ['contact', 'event', 'invoice', 'orderConfirmation', 'quotation', 'voucher', 'voucherlist']
        );

        $this->assertInstanceOf(\Clicksports\LexOffice\Contact\Client::class, $stub->contact());
        $this->assertInstanceOf(\Clicksports\LexOffice\Event\Client::class, $stub->event());
        $this->assertInstanceOf(\Clicksports\LexOffice\Invoice\Client::class, $stub->invoice());
        $this->assertInstanceOf(\Clicksports\LexOffice\OrderConfirmation\Client::class, $stub->orderConfirmation());
        $this->assertInstanceOf(\Clicksports\LexOffice\Quotation\Client::class, $stub->quotation());
        $this->assertInstanceOf(\Clicksports\LexOffice\Voucher\Client::class, $stub->voucher());
        $this->assertInstanceOf(\Clicksports\LexOffice\Voucherlist\Client::class, $stub->voucherlist());
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

    public function testSetCacheInterface()
    {
        $cacheInterface = new FilesystemAdapter(
            'lexoffice',
            3600,
            __DIR__ . '/../cache'
        );

        $cacheKey = 'lex-office--v1--';

        $stub = $this->createApiMockObject(
            new Response(200, [], '{"cache": true}'),
            ['setCacheInterface', 'setCacheResponse', 'getCacheResponse']
        );

        $stub->setCacheInterface($cacheInterface);

        // execute response "curl" with caching in background
        $stub->getResponse();

        $this->assertEquals(
            '{"status":200,"headers":[],"body":"{\"cache\": true}","version":"1.1","reason":"OK"}',
            $cacheInterface->getItem($cacheKey)->get()
        );

        $this->assertEquals(
            $cacheInterface->getItem($cacheKey)->get(),
            $this->transformToString($stub->getCacheResponse())
        );

        $fakeResponse = new Response(200, [], 'fake');

        $stub->setCacheResponse($fakeResponse);

        $this->assertEquals(
            $cacheInterface->getItem($cacheKey)->get(),
            $this->transformToString($fakeResponse)
        );

        // remove cache
        $cacheInterface->deleteItem($cacheKey);
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

    public function testCacheExceptions()
    {
        $this->expectException(CacheException::class);

        $stub = $this->createApiMockObject(
            new Response(),
            ['setCacheResponse']
        );

        $stub->setCacheResponse(new Response());
    }

    public function testCacheOnPost()
    {
        $stub = $this->createApiMockObject(
            new Response(),
            ['setCacheResponse']
        );

        $stub->newRequest('POST', '/');

        $this->assertEquals(
            $stub,
            $stub->setCacheResponse(new Response())
        );
    }

    protected function transformToString(Response $response)
    {
        $obj = new \stdClass();
        $obj->status = $response->getStatusCode();
        $obj->headers = $response->getHeaders();
        $obj->body = $response->getBody()->__toString();
        $obj->version = $response->getProtocolVersion();
        $obj->reason = $response->getReasonPhrase();

        return json_encode($obj);
    }
}
