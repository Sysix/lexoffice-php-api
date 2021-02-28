<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Tests\Clients;

use Clicksports\LexOffice\Clients\Contact;
use GuzzleHttp\Psr7\Response;
use Clicksports\LexOffice\Tests\TestClient;

class ContactTest extends TestClient
{
    public function testGenerateUrl()
    {
        $stub = $this->createClientMockObject(
            Contact::class,
            new Response(200, [], 'body'),
            ['generateUrl']
        );

        $this->assertEquals(
            'contacts?page=0&size=100&direction=ASC&property=name',
            $stub->generateUrl(0)
        );
    }

}
