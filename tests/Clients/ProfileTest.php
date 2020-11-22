<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\Profile;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ProfileTest extends TestClient
{

    public function testGetAll()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Profile::class,
            new Response(200, [], '{}'),
            ['getAll']
        );

        $stub->getAll();
    }

    public function testGet()
    {
        $stub  = $this->createClientMockObject(
            Profile::class,
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
            Profile::class,
            new Response(200, [], '{}'),
            ['create']
        );

        $stub->create([]);
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Profile::class,
            new Response(200, [], '{}'),
            ['update']
        );

        $stub->update('id', []);
    }
}
