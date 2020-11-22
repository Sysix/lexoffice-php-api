<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Voucherlist;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Voucherlist\Client;
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

        $stub->types = ['invoice'];
        $stub->statuses = ['open'];

        $this->assertEquals(
            'voucherlist?page=0&size=100&sort=voucherNumber,DESC&voucherType=invoice&voucherStatus=open',
            $stub->generateUrl(0)
        );
    }

    public function testCreate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['create']
        );

        $stub->create([]);
    }

    public function testGet()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], 'body'),
            ['get']
        );

        $stub->get('resource-id');
    }

    public function testUpdate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['update']
        );

        $stub->update('resource-id', []);
    }
}
