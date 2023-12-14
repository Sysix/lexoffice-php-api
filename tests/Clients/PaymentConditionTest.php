<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\PaymentCondition;
use Sysix\LexOffice\Tests\TestClient;

class PaymentConditionTest extends TestClient
{
    public function testGetAll(): void
    {
        [$api, $stub] = $this->createClientMockObject(PaymentCondition::class);

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/payment-conditions',
            $api->request->getUri()->__toString()
        );
    }
}
