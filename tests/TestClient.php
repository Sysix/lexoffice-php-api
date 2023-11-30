<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use Sysix\LexOffice\Api;
use Sysix\LexOffice\PaginationClient;
use Sysix\LexOffice\ClientInterface;
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
     * @return Api&MockObject
     */
    public function createApiMockObject(Response $response)
    {
        return $this->createApiMultiMockObject([$response]);
    }

    /**
     * @param Response[] $responses
     * @return Api&MockObject
     */
    public function createApiMultiMockObject(array $responses)
    {
        $responseMock = new MockHandler($responses);

        return $this
            ->getMockBuilder(Api::class)
            ->onlyMethods([])
            ->setConstructorArgs([
                '',
                new Client([
                    'handler' => HandlerStack::create($responseMock)
                ])
            ])
            ->getMock();
    }

    /**
     * @template T of ClientInterface
     * @param class-string<T> $className
     * @return T&MockObject
     */
    public function createClientMockObject(string $className, Response $response)
    {
        return $this->createClientMultiMockObject($className, [$response]);
    }

    /**
     * @template T of ClientInterface
     * @param class-string<T> $className
     * @param Response[] $responses
     * @return T&MockObject
     */
    public function createClientMultiMockObject(string $className, array $responses)
    {
        $api = $this->createApiMultiMockObject($responses);

        return $this
            ->getMockBuilder($className)
            ->onlyMethods([])
            ->setConstructorArgs([$api])
            ->getMock();
    }

    /**
     * @param Response[] $responses
     * @return PaginationClient&MockObject
     * @throws ReflectionException
     */
    public function createPaginationClientMockObject(array $responses)
    {
        $api = $this->createApiMultiMockObject($responses);

        $stub = $this
            ->getMockBuilder(PaginationClient::class)
            ->onlyMethods([])
            ->setConstructorArgs([$api])
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

    public function createCacheDir(): void
    {
        $dir = $this->getCacheDir();

        if (!is_dir($dir)) {
            mkdir($dir);
        }
    }

    public function getCacheDir(): string
    {
        return __DIR__ . '/cache';
    }
}