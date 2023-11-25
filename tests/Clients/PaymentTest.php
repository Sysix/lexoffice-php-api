<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\Payment;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class PaymentTest extends TestClient
{
    public function testGet()
    {
        $stub = $this->createClientMockObject(
            Payment::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }
}
