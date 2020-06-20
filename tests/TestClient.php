<?php

namespace Tests;

use Clicksports\LexOffice\Api;
use Clicksports\LexOffice\PaginationClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TestClient extends TestCase
{
    public function createApiMockObject(Response $response, $methodExcept = [])
    {
        return $this->createApiMultiMockObject([$response], $methodExcept);
    }

    public function createApiMultiMockObject(array $responses, $methodExcept = [])
    {
        $responseMock = new MockHandler($responses);

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
                'setRequest',
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
                'getAsJson',
                'createStream'
            ])
            ->getMock();
    }

    public function createPaginationClientMockObject(array $responses, array $methodExcept = [])
    {
        $api = $this->createApiMultiMockObject($responses);

        $stub = $this
            ->getMockBuilder(PaginationClient::class)
            ->setConstructorArgs([$api])
            ->setMethodsExcept([
                ...$methodExcept,
                'getAsJson'
            ])
            ->getMock();

        $this->setProtectedProperty($stub, 'resource', 'resource');

        return $stub;
    }

    /**
     * Sets a protected property on a given object via reflection
     *
     * @param $object - instance in which protected value is being modified
     * @param $property - property on instance being modified
     * @param $value - new value of the property being modified
     *
     * @return void
     *
     * @throws \ReflectionException
     * @link https://stackoverflow.com/a/37667018/7387397
     */
    public function setProtectedProperty($object, $property, $value)
    {
        $reflection = new \ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }
}