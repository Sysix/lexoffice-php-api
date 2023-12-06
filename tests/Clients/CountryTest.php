<?php declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Country;
use Sysix\LexOffice\Tests\TestClient;

class CountryTest extends TestClient
{
    public function testGetAll(): void
    {
        [$api, $client] = $this->createClientMockObject(Country::class);

        $response = $client->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/countries',
            $api->request->getUri()->__toString()
        );
    }
}
