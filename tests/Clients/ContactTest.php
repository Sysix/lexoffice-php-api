<?php

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\Contact;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class ContactTest extends TestClient
{
    public function testGenerateUrl(): void
    {
        $stub = $this->createClientMockObject(
            Contact::class,
            new Response(200, [], 'body')
        );

        $this->assertEquals(
            'contacts?page=0&size=100&direction=ASC&property=name',
            $stub->generateUrl(0)
        );
    }

    public function testCreate(): void
    {
        $stub = $this->createClientMockObject(
            Contact::class,
            new Response(200, [], 'body')
        );

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGet(): void
    {
        $stub = $this->createClientMockObject(
            Contact::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testUpdate(): void
    {
        $stub = $this->createClientMockObject(
            Contact::class,
            new Response(200, [], 'body')
        );

        $response = $stub->update('resource-id', []);

        $this->assertEquals('body', $response->getBody()->__toString());
    }
}
