<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Dunning;
use Sysix\LexOffice\Tests\TestClient;

final class DunningTest extends TestClient
{
    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(Dunning::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/dunnings/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testPursue(): void
    {
        [$api, $stub] = $this->createClientMockObject(Dunning::class);

        $response = $stub->pursue('resource-id', [
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/dunnings?precedingSalesVoucherId=resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testDocument(): void
    {
        $this->expectDeprecationV1Warning('document');

        [$api, $stub] = $this->createClientMockObject(Dunning::class);

        $response = $stub->document('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/dunnings/resource-id/document',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testDocumentContent(): void
    {
        $this->expectDeprecationV1Warning('document');

        [$api, $stub] = $this->createClientMockObject(Dunning::class);

        $response = $stub->document('resource-id', true);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/dunnings/resource-id/file',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testFileContent(): void
    {
        [$api, $stub] = $this->createClientMockObject(Dunning::class);

        $response = $stub->file('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/dunnings/resource-id/file',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
