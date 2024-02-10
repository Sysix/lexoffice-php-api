<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Sysix\LexOffice\Api;
use Sysix\LexOffice\PaginationClient;

class PaginationClientTest extends TestClient
{
    /**
     * @param Response[] $responses
     *
     * @return array{0: Api&MockObject, 1: PaginationClient}
     */
    public function createPaginationClientMockObject(array $responses)
    {
        $api = $this->createApiMultiMockObject($responses);

        $stub = new class ($api) extends PaginationClient {
            protected string $resource = 'resource';
        };

        return [$api, $stub];
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

    public function testGetMultipleWithError(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [, $stub] = $this->createPaginationClientMockObject(
            [
                new Response(200, ['Content-Type' => 'application/json'], '{"content": [{"name": "a"}], "totalPages": 3}'),
                new Response(500)
            ]
        );

        $this->assertEquals(500, $stub->getAll()->getStatusCode());
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
