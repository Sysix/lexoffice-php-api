<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests;

use GuzzleHttp\Psr7\Response;

class PaginationClientTest extends TestClient
{

    public function testGenerateUrl()
    {
        $stub = $this->createPaginationClientMockObject(
            [new Response()]
        );

        $this->assertEquals(
            'resource?page=0&size=100',
            $stub->generateUrl(0)
        );
    }

    public function testGetAll()
    {
        $stub = $this->createPaginationClientMockObject(
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $this->assertEquals(
            '{"content": [], "totalPages": 1}',
            $stub->getAll()->getBody()->__toString()
        );


        $stub = $this->createPaginationClientMockObject(
            [
                new Response(200, [], '{"content": [{"name": "a"}], "totalPages": 2}'),
                new Response(200, [], '{"content": [{"name": "b"}], "totalPages": 2}')
            ]
        );

        $this->assertEquals(
            '{"content":[{"name":"a"},{"name":"b"}],"totalPages":2}',
            $stub->getAll()->getBody()->__toString()
        );
    }

    public function testGetPage()
    {
        $stub = $this->createPaginationClientMockObject(
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $this->assertEquals(
            '{"content": [], "totalPages": 1}',
            $stub->getPage(0)->getBody()->__toString()
        );
    }
}
