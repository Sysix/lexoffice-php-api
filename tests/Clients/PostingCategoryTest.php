<?php

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\PostingCategory;
use Clicksports\LexOffice\Tests\TestClient;
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
