<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Config\FileClient\VoucherConfig;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Sysix\LexOffice\Clients\File;
use Sysix\LexOffice\Tests\TestClient;

class FileTest extends TestClient
{
    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(File::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/files/resource-id',
            $api->request->getUri()->__toString()
        );
    }

    public function testUploadNotSupportedExtension(): void
    {
        $this->expectException(LexOfficeApiException::class);

        [, $stub] = $this->createClientMockObject(File::class);

        $stub->upload('not_allowed.gif', 'voucher');
    }

    public function testUploadNotFound(): void
    {
        $this->expectException(LexOfficeApiException::class);

        [, $stub] = $this->createClientMockObject(File::class);

        $stub->upload('not_existing.jpg', 'voucher');
    }

    public function testUploadToBig(): void
    {
        $this->expectException(LexOfficeApiException::class);

        [, $stub] = $this->createClientMockObject(File::class);

        $this->createCacheDir();
        $file = $this->getCacheDir() . '/somefile.jpg';
        $fp = fopen($file, 'w+');

        if ($fp === false) {
            $this->fail('could not open file ' . $file);
        }

        fseek($fp, VoucherConfig::MAX_FILE_SIZE + 1, SEEK_CUR);
        fwrite($fp, 'a');
        fclose($fp);

        $stub->upload($file, 'voucher');

        unlink($file);
    }

    public function testUploadSuccess(): void
    {
        [$api, $stub] = $this->createClientMockObject(File::class);

        $this->createCacheDir();
        $file = $this->getCacheDir() .  '/somefile2.jpg';
        $fp = fopen($file, 'w+');

        if ($fp === false) {
            $this->fail('could not open file ' . $file);
        }

        fseek($fp, 5, SEEK_CUR);
        fwrite($fp, 'a');
        fclose($fp);

        $response = $stub->upload($file, 'voucher');

        unlink($file);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->request->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/files',
            $api->request->getUri()->__toString()
        );

        $this->assertStringContainsString(
            'multipart/form-data',
            $api->request->getHeaderLine('Content-Type')
        );
    }
}
