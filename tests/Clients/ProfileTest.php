<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\Profile;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ProfileTest extends TestClient
{
    public function testGet()
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
