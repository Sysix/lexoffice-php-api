<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\PrintLayout;
use Sysix\LexOffice\Tests\TestClient;

final class PrintLayoutTest extends TestClient
{
    public function testGetAll(): void
    {
        [$api, $stub] = $this->createClientMockObject(PrintLayout::class);

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/print-layouts',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
