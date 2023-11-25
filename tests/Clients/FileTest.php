<?php

namespace Sysix\LexOffice\Tests\Clients;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Sysix\LexOffice\Clients\File;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Tests\TestClient;

class FileTest extends TestClient
{
    public function testUploadNotSupportedExtension()
    {
        $this->expectException(LexOfficeApiException::class);

        $stub  = $this->createClientMockObject(
            File::class,
            new Response(200, [], '{}')
        );

        $stub->upload('not_allowed.gif', 'voucher');
    }

    public function testUploadNotFound()
    {
        $this->expectException(LexOfficeApiException::class);

        $stub  = $this->createClientMockObject(
            File::class,
            new Response(200, [], '{}')
        );

        $stub->upload('not_existing.jpg', 'voucher');
    }

    public function testUploadToBig()
    {
        $this->expectException(LexOfficeApiException::class);

        $stub  = $this->createClientMockObject(
            File::class,
            new Response(200, [], '{}')
        );

        $file = __DIR__ . '/../cache/somefile.jpg';
        $fp = fopen($file, 'w+'); //
        fseek($fp, File::MAX_FILE_SIZE + 1,SEEK_CUR);
        fwrite($fp,'a');
        fclose($fp);

        $stub->upload($file, 'voucher');

        unlink($file);
    }

    public function testUpload()
    {
        $stub  = $this->createClientMockObject(
            File::class,
            new Response(200, [], '{}')
        );

        $file = __DIR__ . '/../cache/somefile2.jpg';
        $fp = fopen($file, 'w+'); //
        fseek($fp, 5,SEEK_CUR);
        fwrite($fp,'a');
        fclose($fp);

        $response = $stub->upload($file, 'voucher');

        unlink($file);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
