<?php

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\RecurringTemplate;
use Clicksports\LexOffice\Tests\TestClient;
use GuzzleHttp\Psr7\Response;

class RecurringTemplateTest extends TestClient
{
    public function testGet(): void
    {
        $stub = $this->createClientMockObject(
            RecurringTemplate::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGenerateUrl(): void
    {
        $stub = $this->createClientMockObject(
            RecurringTemplate::class,
            new Response(200, [], 'body')
        );

        $this->assertEquals(
            'recurring-templates?page=0&size=100',
            $stub->generateUrl(0)
        );
    }

}
