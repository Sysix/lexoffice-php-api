<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Tests\Clients;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\Voucher;
use Sysix\LexOffice\Config\FileClient\VoucherConfig;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Sysix\LexOffice\Tests\TestClient;

class VoucherTest extends TestClient
{
    public function testCreate(): void
    {
        [$api, $stub] = $this->createClientMockObject(Voucher::class);

        $response = $stub->create([
            'version' => 0
        ]);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testGet(): void
    {
        [$api, $stub] = $this->createClientMockObject(Voucher::class);

        $response = $stub->get('resource-id');

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testUpdate(): void
    {
        [$api, $stub]  = $this->createClientMockObject(Voucher::class);

        $response = $stub->update('resource-id', []);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('PUT', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers/resource-id',
            $api->getRequest()->getUri()->__toString()
        );
    }

    public function testUploadNotSupportedExtension(): void
    {
        $this->expectException(LexOfficeApiException::class);

        [, $stub] = $this->createClientMockObject(Voucher::class);

        $stub->upload('resource-id', 'not_allowed.gif');
    }

    public function testUploadNotFound(): void
    {
        $this->expectException(LexOfficeApiException::class);

        [, $stub] = $this->createClientMockObject(Voucher::class);

        $stub->upload('resource-id', 'not_existing.jpg');
    }

    public function testUploadToBig(): void
    {
        $this->expectException(LexOfficeApiException::class);

        [, $stub] = $this->createClientMockObject(Voucher::class);

        $this->createCacheDir();
        $file = $this->getCacheDir() . '/somefile.jpg';
        $fp = fopen($file, 'w+');

        if ($fp === false) {
            $this->fail('could not open file ' . $file);
        }

        fseek($fp, VoucherConfig::MAX_FILE_SIZE + 1, SEEK_CUR);
        fwrite($fp, 'a');
        fclose($fp);

        $stub->upload('resource-id', $file);

        unlink($file);
    }

    public function testUploadSuccess(): void
    {
        [$api, $stub] = $this->createClientMockObject(Voucher::class);

        $this->createCacheDir();
        $file = $this->getCacheDir() .  '/somefile2.jpg';
        $fp = fopen($file, 'w+');

        if ($fp === false) {
            $this->fail('could not open file ' . $file);
        }

        fseek($fp, 5, SEEK_CUR);
        fwrite($fp, 'a');
        fclose($fp);

        $response = $stub->upload('resource-id', $file);

        unlink($file);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('POST', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/vouchers/resource-id/files',
            $api->getRequest()->getUri()->__toString()
        );

        $this->assertStringContainsString(
            'multipart/form-data',
            $api->getRequest()->getHeaderLine('Content-Type')
        );
    }

    public function testGetAll(): void
    {
        $this->expectDeprecationV1Warning('getAll');

        [$api, $stub] = $this->createClientMultiMockObject(
            Voucher::class,
            [new Response(200, [], '{"content": [], "totalPages": 1}')]
        );

        $response = $stub->getAll();

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertEquals('GET', $api->getRequest()->getMethod());
        $this->assertEquals(
            $api->apiUrl . '/v1/voucherlist?page=0&voucherType=salesinvoice%2Csalescreditnote%2Cpurchaseinvoice%2Cpurchasecreditnote&voucherStatus=open%2Cpaid%2Cpaidoff%2Cvoided%2Ctransferred%2Csepadebit&size=100&sort=voucherNumber%2CDESC',
            $api->getRequest()->getUri()->__toString()
        );
    }
}
