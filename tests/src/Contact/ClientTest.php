<?php

namespace Tests\Src\Contact;

use Clicksports\LexOffice\Contact\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestClient;

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
            'contacts?page=0&size=100&direction=ASC&property=name',
            $stub->generateUrl(0)
        );
    }

}
