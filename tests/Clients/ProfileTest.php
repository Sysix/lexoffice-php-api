<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\Profile;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class ProfileTest extends TestClient
{
    public function testGet(): void
    {
        $stub = $this->createClientMockObject(
            Profile::class,
            new Response(200, [], '{}')
        );

        $this->assertEquals(
            '{}',
            $stub->get()->getBody()->__toString()
        );
    }
}
