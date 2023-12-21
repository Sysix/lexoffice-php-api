<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Config\FileClientConfig;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Sysix\LexOffice\Utils;

class File extends BaseClient
{
    protected string $resource = 'files';

    public function get(string $id, string $acceptHeader = '*/*'): ResponseInterface
    {
        $this->api->newRequest('GET', $this->resource . '/' . rawurlencode($id));

        $this->api->setRequest($this->api->getRequest()->withHeader('Accept', $acceptHeader));

        return $this->api->getResponse();
    }

    /**
     * @throws LexOfficeApiException
     */
    public function upload(string $filepath, string $type): ResponseInterface
    {
        if ($type !== 'voucher') {
            throw new \InvalidArgumentException('only upload type voucher is supported');
        }

        $config = FileClientConfig::getVoucherConfig();
        $config->validateFileFromFilePath($filepath);

        $body = Utils::createMultipartStream([
            'file' => fopen($filepath, 'r'),
            'type' => $type
        ]);

        $api = $this->api->newRequest('POST', $this->resource, [
            'Content-Type' => 'multipart/form-data; boundary=' . $body->getBoundary()
        ]);

        $api->setRequest($api->getRequest()->withBody($body));

        return $api->getResponse();
    }
}
