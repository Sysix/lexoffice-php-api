<?php

namespace Tests;

use Clicksports\LexOffice\Api;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TestClient extends TestCase
{
    public function createApiMockObject(Response $response, $methodExcept = [])
    {
        $responseMock = new MockHandler([$response]);

        return $this
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
    }

    public function createClientMockObject(string $className, Response $response, array $methodExcept = [])
    {
        $api = $this->createApiMockObject($response);

        return $this
            ->getMockBuilder($className)
            ->setConstructorArgs([$api])
            ->setMethodsExcept([
                ...$methodExcept,
                'createStream'
            ])
            ->getMock();
    }
}