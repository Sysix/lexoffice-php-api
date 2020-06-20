<?php

namespace Tests;

use Clicksports\LexOffice\Api;
use Clicksports\LexOffice\Exceptions\CacheException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class ApiTest extends TestCase
{
    public function createApiMock(Response $response, $methodExcept = [])
    {
        $responseMock = new MockHandler([$response]);

        $stub = $this
            ->getMockBuilder(Api::class)
            ->setConstructorArgs([
                '',
                new Client([
                    'handler' => HandlerStack::create($responseMock)
                ])
            ])
            ->setMethodsExcept([
                ...$methodExcept,
                'newRequest',
                'getResponse'
            ])
            ->getMock();

        /** @noinspection PhpUndefinedMethodInspection */
        $stub->newRequest('GET', '/');

        return $stub;
    }

    public function testClients()
    {
        $stub = $this->createApiMock(
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

    public function testSetCacheInterface()
    {
        $cacheInterface = new FilesystemAdapter(
            'lexoffice',
            3600,
            __DIR__ . '/cache'
        );

        $cacheKey = 'lex-office--v1--';

        $stub = $this->createApiMock(
            new Response(200, [], '{"cache": true}'),
            ['setCacheInterface', 'setCacheResponse', 'getCacheResponse']
        );

        /** @noinspection PhpUndefinedMethodInspection */
        $stub->setCacheInterface($cacheInterface);

        $response = $stub->getResponse();

        $this->assertEquals(
            '{"cache": true}',
            $response->getBody()->__toString()
        );

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
        $stub = $this->createApiMock(
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

        $stub = $this->createApiMock(
            new Response(),
            ['setCacheResponse']
        );

        $stub->setCacheResponse(new Response());
    }

    public function testCacheOnPost()
    {
        $stub = $this->createApiMock(
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
