<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests;

use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sysix\LexOffice\Utils;

class UtilsTest extends TestCase
{
    public function testGetJsonFromResponseWithoutAnHeader(): void
    {
        $response = new Response();
        $json = Utils::getJsonFromResponse($response);

        $this->assertNull($json);
    }

    public function testGetJsonFromResponseWithInvalidHeader(): void
    {
        $response = new Response(200, [
            'Content-Type' => 'application/xml'
        ]);
        $json = Utils::getJsonFromResponse($response);

        $this->assertNull($json);
    }

    public function testGetJsonFromResponseWithValidHeader(): void
    {
        $response = new Response(200, [
            'Content-Type' => 'application/json'
        ], (string) json_encode([
            'test' => true
        ]));
        $json = Utils::getJsonFromResponse($response);

        $this->assertEquals((object)[
            'test' => true
        ], $json);
    }

    public function testGetJsonFromResponseWithValidCharsetHeader(): void
    {
        $response = new Response(200, [
            'Content-Type' => 'application/json; charset=utf-8'
        ], (string) json_encode([
            'test' => true
        ]));
        $json = Utils::getJsonFromResponse($response);

        $this->assertEquals((object)[
            'test' => true
        ], $json);
    }

    public function testJsonDecodeValid(): void
    {
        $json = Utils::jsonDecode('{"content":"test","object":{"content":"test2"}}');

        $this->assertEquals($json, (object)[
            'content' => 'test',
            'object' => (object) [
                'content' => 'test2'
            ]
        ]);
    }

    public function testJsonDecodeInValid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Utils::jsonDecode('{content:"test"}'); // missing quotes for key
    }

    public function testJsonEncodeValid(): void
    {
        $jsonString = Utils::jsonEncode((object)[
            'content' => 'test',
            'object' => (object) [
                'content' => 'test2'
            ]
        ]);

        $this->assertEquals('{"content":"test","object":{"content":"test2"}}', $jsonString);
    }

    public function testJsonEncodeInValid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Utils::jsonEncode(fopen('php://temp', 'r'));
    }
}
