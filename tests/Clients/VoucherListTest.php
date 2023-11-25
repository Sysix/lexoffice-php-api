<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\VoucherList;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class VoucherListTest extends TestClient
{

    public function testGenerateUrl()
    {
        $stub = $this->createClientMockObject(
            VoucherList::class,
            new Response(200, [], 'body')
        );

        $stub->types = ['invoice'];
        $stub->statuses = ['open'];

        $this->assertEquals(
            'voucherlist?page=0&size=100&sort=voucherNumber,DESC&voucherType=invoice&voucherStatus=open',
            $stub->generateUrl(0)
        );
    }
}
