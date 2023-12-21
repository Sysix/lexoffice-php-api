<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionException;
use Sysix\LexOffice\Api;
use Sysix\LexOffice\PaginationClient;

class PaginationClientTest extends TestClient
{
    /**
     * @param Response[] $responses
     *
     * @throws ReflectionException
     *
     * @return array{0: Api&MockObject, 1: PaginationClient&MockObject}
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

        return [$api, $stub];
    }

    /**
     * Sets a protected property on a given object via reflection.
     *
     * @param object $object   - instance in which protected value is being modified
     * @param string $property - property on instance being modified
     * @param mixed  $value    - new value of the property being modified
     *
     * @throws ReflectionException
     *
     * @see https://stackoverflow.com/a/37667018/7387397
     */
    public function setProtectedProperty(object $object, string $property, $value): void
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }

    public function testGetAllSingle(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [, $stub] = $this->createPaginationClientMockObject(
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $this->assertEquals(
            '{"content": [], "totalPages": 1}',
            $stub->getAll()->getBody()->__toString()
        );
    }

    public function testGetAllMultiple(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [, $stub] = $this->createPaginationClientMockObject(
            [
                new Response(200, ['Content-Type' => 'application/json'], '{"content": [{"name": "a"}], "totalPages": 2}'),
                new Response(200, ['Content-Type' => 'application/json'], '{"content": [{"name": "b"}], "totalPages": 2}')
            ]
        );

        $this->assertEquals(
            '{"content":[{"name":"a"},{"name":"b"}],"totalPages":2}',
            $stub->getAll()->getBody()->__toString()
        );
    }

    public function testGetPage(): void
    {
        [$api, $stub] = $this->createPaginationClientMockObject(
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $stub->getPage(0);

        $this->assertEquals(
            $api->apiUrl . '/v1/resource?page=0&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
