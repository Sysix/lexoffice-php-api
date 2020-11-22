<?php

namespace Clicksports\LexOffice\Tests;

use Clicksports\LexOffice\Api;
use Clicksports\LexOffice\ClientInterface;
use Clicksports\LexOffice\PaginationClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class TestClient extends TestCase
{
    /**
     * @param Response $response
     * @param string[] $methodExcept
     * @return Api|MockObject
     */
    public function createApiMockObject(Response $response, $methodExcept = [])
    {
        return $this->createApiMultiMockObject([$response], $methodExcept);
    }

    /**
     * @param Response[] $responses
     * @param string[] $methodExcept
     * @return MockObject|Api
     */
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

    /**
     * @param string $className
     * @param Response $response
     * @param string[] $methodExcept
     * @return MockObject|ClientInterface
     */
    public function createClientMockObject(string $className, Response $response, array $methodExcept = [])
    {
        return $this->createClientMultiMockObject($className, [$response], $methodExcept);
    }

    /**
     * @param string<object> $className
     * @param Response[] $responses
     * @param string[] $methodExcept
     * @return MockObject|ClientInterface
     */
    public function createClientMultiMockObject(string $className, array $responses, array $methodExcept = [])
    {
        $api = $this->createApiMultiMockObject($responses);

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

    /**
     * @param Response[] $responses
     * @param string[] $methodExcept
     * @return MockObject|PaginationClient
     * @throws ReflectionException
     */
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
     * @param object $object - instance in which protected value is being modified
     * @param string $property - property on instance being modified
     * @param mixed $value - new value of the property being modified
     *
     * @return void
     *
     * @throws ReflectionException
     * @link https://stackoverflow.com/a/37667018/7387397
     */
    public function setProtectedProperty(object $object, string $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }
}