<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Voucher;
use Sysix\LexOffice\Tests\TestClient;

class VoucherTest extends TestClient
{

    public function testCreate(): void
    {
        [$api, $stub] = $this->createClientMockObject(Voucher::class);

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers',
            $api->request->getUri()->__toString()
        );
    }

    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(Voucher::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers/resource-id',
            $api->request->getUri()->__toString()
        );
    }

    public function testUpdate(): void
    {
        [$api, $stub]  = $this->createClientMockObject(Voucher::class);

        $response = $stub->update('resource-id', []);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('PUT', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers/resource-id',
            $api->request->getUri()->__toString()
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            Voucher::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=salesinvoice%2Csalescreditnote%2Cpurchaseinvoice%2Cpurchasecreditnote&voucherStatus=open%2Cpaid%2Cpaidoff%2Cvoided%2Ctransferred%2Csepadebit&size=100',
            $api->request->getUri()->__toString()
        );
    }
}
