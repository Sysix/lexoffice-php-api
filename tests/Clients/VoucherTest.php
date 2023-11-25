<?php

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\Voucher;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class VoucherTest extends TestClient
{

    public function testCreate()
    {
        $stub  = $this->createClientMockObject(
            Voucher::class,
            new Response(200, [], 'body')
        );

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGet()
    {
        $stub  = $this->createClientMockObject(
            Voucher::class,
            new Response(200, [], 'body')
        );

        $response = $stub->get('resource-id');

        $this->assertEquals('body', $response->getBody()->__toString());
    }

    public function testGetAll()
    {
        $stub  = $this->createClientMockObject(
            Voucher::class,
            new Response(200, [], '{"content": [], "totalPages": 1}')
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }

    public function testUpdate()
    {
        $stub  = $this->createClientMockObject(
            Voucher::class,
            new Response(200, [], '{}')
        );

        $response = $stub->update('resource-id', []);

        $this->assertEquals('{}', $response->getBody()->__toString());
    }
}
