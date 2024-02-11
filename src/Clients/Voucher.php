<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\UpdateTrait;
use Sysix\LexOffice\Config\FileClientConfig;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Sysix\LexOffice\Utils;

class Voucher extends BaseClient
{
    use CreateTrait;
    use GetTrait;
    use UpdateTrait;

    protected string $resource = 'vouchers';

    /**
     * @throws LexOfficeApiException
     */
    public function upload(string $id, string $filepath): ResponseInterface
    {
        $config = FileClientConfig::getVoucherConfig();
        $config->validateFileFromFilePath($filepath);

        $body = Utils::createMultipartStream([
            'file' => fopen($filepath, 'r')
        ]);

        $api = $this->api->newRequest('POST', $this->resource . '/' . rawurlencode($id) . '/files', [
            'Content-Type' => 'multipart/form-data; boundary=' . $body->getBoundary()
        ]);

        return $api
            ->setRequest($api->getRequest()->withBody($body))
            ->getResponse();
    }

    /**
     * @deprecated 1.0 Not recommend anymore because of Rate Limiting, WILL be removed in 2.0
     */
    public function getAll(): ResponseInterface
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

        $client = new VoucherList($this->api);

        /**
         * @see https://developers.lexoffice.io/docs/#vouchers-endpoint-purpose
         */
        $client->statuses = ['open', 'paid', 'paidoff', 'voided', 'transferred', 'sepadebit'];
        $client->types = ['salesinvoice', 'salescreditnote', 'purchaseinvoice', 'purchasecreditnote'];

        return $client->getAll();
    }
}
