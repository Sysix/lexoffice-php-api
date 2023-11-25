<?php

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\PostingCategory;
use Sysix\LexOffice\Tests\TestClient;
use GuzzleHttp\Psr7\Response;

class PostingCategoryTest extends TestClient
{
    public function testGetAll(): void
    {
        $stub = $this->createClientMockObject(
            PostingCategory::class,
            new Response(200, [], '{"content": [], "totalPages": 1}')
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }
}
