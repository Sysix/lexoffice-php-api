<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\VoucherList;
use Sysix\LexOffice\Tests\TestClient;

class VoucherListTest extends TestClient
{
    public function testGetPage(): void
    {
        [$api, $stub] = $this->createClientMockObject(VoucherList::class);

        $stub->types = ['invoice'];
        $stub->statuses = ['open'];
        $stub->archived = true;

        $response = $stub->getPage(0);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&voucherType=invoice&voucherStatus=open&archived=1&size=100&sort=voucherNumber%2CDESC',
            $api->request->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            VoucherList::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $stub->types = ['invoice'];
        $stub->statuses = ['open'];
        $stub->archived = true;

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&voucherType=invoice&voucherStatus=open&archived=1&size=100&sort=voucherNumber%2CDESC',
            $api->request->getUri()->__toString()
        );
    }
}
