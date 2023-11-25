<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\Payment;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class PaymentTest extends TestClient
{
    public function testGet(): void
    {
        $stub = $this->createClientMockObject(
            Payment::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }
}
