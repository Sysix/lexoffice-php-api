<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Clients\Country;
use GuzzleHttp\Psr7\Response;
use Sysix\LexOffice\Tests\TestClient;

class CountryTest extends TestClient
{
    public function testGetAll(): void
    {
        $stub = $this->createClientMockObject(
            Country::class,
            new Response(200, [], '{"content": [], "totalPages": 1}')
        );

        $response = $stub->getAll();

        $this->assertEquals('{"content": [], "totalPages": 1}', $response->getBody()->__toString());
    }
}
