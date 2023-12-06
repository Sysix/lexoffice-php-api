<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

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
            'https://api.lexoffice.io/v1/voucherlist?page=0&sort=voucherNumber%2CDESC&voucherType=invoice&voucherStatus=open&archived=1&size=100',
            $api->request->getUri()->__toString()
        );
    }
}
