<?php

namespace Clicksports\LexOffice\Tests\Profile;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Profile\Client;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{

    public function testGetAll()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}')
        );

        $stub->getAll();
    }

    public function testGet()
    {
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}')
        );

        $this->assertEquals(
            '{}',
            $stub->get()->getBody()->__toString()
        );
    }

    public function testCreate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}')
        );

        $stub->create([]);
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}')
        );

        $stub->update('id', []);
    }
}
