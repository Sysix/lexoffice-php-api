<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Event;
use Sysix\LexOffice\Tests\TestClient;

class EventTest extends TestClient
{
    public function testCreate(): void
    {
        [$api, $stub] = $this->createClientMockObject(Event::class);

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/event-subscriptions',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(Event::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/event-subscriptions/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testDelete(): void
    {
        [$api, $stub] = $this->createClientMockObject(Event::class);

        $response = $stub->delete('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('DELETE', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/event-subscriptions/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        [$api, $stub] = $this->createClientMockObject(Event::class);

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/event-subscriptions',
            $api->getRequest()->getUri()->__toString()
        );
    }

}
