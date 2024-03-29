<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\RecurringTemplate;
use Sysix\LexOffice\Tests\TestClient;

class RecurringTemplateTest extends TestClient
{
    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(RecurringTemplate::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/recurring-templates/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGetPage(): void
    {
        [$api, $stub] = $this->createClientMockObject(RecurringTemplate::class);

        $stub->getPage(0);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/recurring-templates?page=0&size=100&sort=updatedDate%2CDESC',
            $api->getRequest()->getUri()->__toString()
        );
    }

}
