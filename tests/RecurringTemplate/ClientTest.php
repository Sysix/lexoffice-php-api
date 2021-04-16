<?php

namespace Clicksports\LexOffice\Tests\RecurringTemplate;

use Clicksports\LexOffice\RecurringTemplate\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{
    public function testGenerateUrl()
    {
        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['generateUrl']
        );

        $this->assertEquals(
            'recurring-templates?page=0&size=100',
            $stub->generateUrl(0)
        );
    }

}
