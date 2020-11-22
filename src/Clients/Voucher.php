<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Voucher extends BaseClient
{
    protected string $resource = 'vouchers';

    /**
     * @param string $id
     * @param array[] $data
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . $id);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        $client = new VoucherList($this->api);

        /**
         * @link https://developers.lexoffice.io/docs/#vouchers-endpoint-purpose
         */
        $client->statuses = ['open', 'paid', 'paidoff', 'voided', 'transferred', 'sepadebit'];
        $client->types = ['salesinvoice', 'salescreditnote', 'purchaseinvoice', 'purchasecreditnote'];

        return $client->getAll();
    }
}
