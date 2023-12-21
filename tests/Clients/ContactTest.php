<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Contact;
use Sysix\LexOffice\Tests\TestClient;

class ContactTest extends TestClient
{
    public function testGetPage(): void
    {
        [$api, $client] = $this->createClientMockObject(Contact::class);

        $response = $client->getPage(0);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/contacts?page=0&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetPageWithFilters(): void
    {
        [$api, $client] = $this->createClientMockObject(Contact::class);

        $client->number = 12345;
        $client->customer = true;
        $client->vendor = false;

        $client->getPage(0);

        $this->assertEquals(
            $api->apiUrl . '/v1/contacts?page=0&number=12345&customer=1&vendor=0&size=100',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testCreate(): void
    {
        [$api, $client] = $this->createClientMockObject(Contact::class);

        $response = $client->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl .  '/v1/contacts',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGet(): void
    {
        [$api, $client] = $this->createClientMockObject(Contact::class);

        $response = $client->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/contacts/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testUpdate(): void
    {
        [$api, $client] = $this->createClientMockObject(Contact::class);

        $response = $client->update('resource-id', []);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('PUT', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/contacts/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
