<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Config\FileClientConfig;
use Sysix\LexOffice\Utils;

class File extends BaseClient
{
    use GetTrait;

    protected string $resource = 'files';

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

        $api->request = $api->request->withBody($body);

        return $api->getResponse();
    }
}
