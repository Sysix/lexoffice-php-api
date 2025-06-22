<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Article;
use Sysix\LexOffice\Tests\TestClient;

final class ArticleTest extends TestClient
{
    public function testGetPage(): void
    {
        [$api, $client] = $this->createClientMockObject(Article::class);

        $response = $client->getPage(0);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/articles?page=0&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetPageWithFilters(): void
    {
        [$api, $client] = $this->createClientMockObject(Article::class);

        $client->articleNumber = 'LXW-BUHA-2024-001';
        $client->gtin = '9783648170632';
        $client->type = 'PRODUCT';

        $client->getPage(0);

        $this->assertEquals(
            $api->apiUrl . '/v1/articles?page=0&articleNumber=LXW-BUHA-2024-001&gtin=9783648170632&type=PRODUCT&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testCreate(): void
    {
        [$api, $client] = $this->createClientMockObject(Article::class);

        $response = $client->create([
            'title' => 'test'
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl .  '/v1/articles',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGet(): void
    {
        [$api, $client] = $this->createClientMockObject(Article::class);

        $response = $client->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/articles/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testUpdate(): void
    {
        [$api, $client] = $this->createClientMockObject(Article::class);

        $response = $client->update('resource-id', []);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('PUT', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/articles/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testDelete(): void
    {
        [$api, $client] = $this->createClientMockObject(Article::class);

        $response = $client->delete('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('DELETE', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/articles/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
