<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sysix\LexOffice\Api;
use Sysix\LexOffice\Interfaces\ClientInterface;

class TestClient extends TestCase
{
    protected function tearDown(): void
    {
        // see self::expectDeprecationV1Warning()
        restore_error_handler();
    }
    /**
     * @return Api&MockObject
     */
    public function createApiMockObject(Response $response)
    {
        return $this->createApiMultiMockObject([$response]);
    }

    /**
     * @param Response[] $responses
     *
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
     *
     * @param class-string<T> $className
     *
     * @return array{0: Api&MockObject, 1: T&MockObject}
     */
    public function createClientMockObject(string $className): array
    {
        return $this->createClientMultiMockObject($className, [new Response()]);
    }

    /**
     * @template T of ClientInterface
     *
     * @param class-string<T> $className
     * @param Response[]      $responses
     *
     * @return array{0: Api&MockObject, 1: T&MockObject}
     */
    public function createClientMultiMockObject(string $className, array $responses): array
    {
        $api = $this->createApiMultiMockObject($responses);

        $client = $this
            ->getMockBuilder($className)
            ->onlyMethods([])
            ->setConstructorArgs([$api])
            ->getMock();

        return [$api, $client];
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

    public function expectDeprecationV1Warning(string $method): void
    {
        set_error_handler(static function (int $errno, string $errstr): void {
            throw new DeprecationException($errstr, $errno);
        }, E_USER_DEPRECATED);

        $this->expectException(DeprecationException::class);

        // we can not check for full class names, because we are mocking objects
        $this->expectExceptionMessage('::' . $method . ' should not be called anymore, in future versions this method WILL not exist');
    }
}
