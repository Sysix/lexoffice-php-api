<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\PostingCategory;
use Sysix\LexOffice\Tests\TestClient;

class PostingCategoryTest extends TestClient
{
    public function testGetAll(): void
    {
        [$api, $stub] = $this->createClientMockObject(PostingCategory::class);

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/posting-categories',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
