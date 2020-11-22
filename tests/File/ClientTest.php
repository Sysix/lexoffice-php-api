<?php

namespace CliockSports\LexOffice\Tests\File;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\File\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Clicksports\LexOffice\Tests\TestClient;

class ClientTest extends TestClient
{
    public function testUploadNotSupportedExtension()
    {
        $this->expectException(LexOfficeApiException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['upload']
        );

        $stub->upload('not_allowed.gif', 'voucher');
    }

    public function testUploadNotFound()
    {
        $this->expectException(LexOfficeApiException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['upload']
        );

        $stub->upload('not_existing.jpg', 'voucher');
    }

    public function testUploadToBig()
    {
        $this->expectException(LexOfficeApiException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['upload']
        );

        $file = __DIR__ . '/somefile.jpg';
        $fp = fopen($file, 'w+'); //
        fseek($fp, Client::MAX_FILE_SIZE + 1,SEEK_CUR);
        fwrite($fp,'a');
        fclose($fp);

        $stub->upload($file, 'voucher');

        unlink($file);
    }

    public function testUpload()
    {
        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['upload']
        );

        $file = __DIR__ . '/somefile2.jpg';
        $fp = fopen($file, 'w+'); //
        fseek($fp, 5,SEEK_CUR);
        fwrite($fp,'a');
        fclose($fp);

        $response = $stub->upload($file, 'voucher');

        unlink($file);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function testCreate()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['create']
        );

        $stub->create([]);
    }

    public function testGetAll()
    {
        $this->expectException(BadMethodCallException::class);

        $stub  = $this->createClientMockObject(
            Client::class,
            new Response(200, [], '{}'),
            ['getAll']
        );

        $stub->getAll();
    }
}
