<?php

namespace src\Profile;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Profile\Client;
use GuzzleHttp\Psr7\Response;
use Tests\TestClient;

class ClientTest extends TestClient
{

    public function testGetAll()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['getAll']
        );

        $stub->getAll();
    }

    public function testGet()
    {
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['get']
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
            new Response(200, [], '{}'),
            ['create']
        );

        $stub->create([]);
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['update']
        );

        $stub->update('id', []);
    }
}
