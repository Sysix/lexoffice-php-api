<?php

namespace Clicksports\LexOffice\Voucher;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;
use function GuzzleHttp\Psr7\stream_for;

class Client extends BaseClient
{
    protected string $resource = 'vouchers';

    /**
     * @param string $id
     * @param array $data
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws GuzzleException
     */
    public function update(string $id, array $data)
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . $id);

        $api->request = $api->request->withBody(stream_for(
            http_build_query($data)
        ));

        return $api->getResponse();
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        /**
         * @link https://developers.lexoffice.io/docs/#vouchers-endpoint-purpose
         */
        $client->statuses = ['open', 'paid', 'paidoff', 'voided', 'transferred', 'sepadebit'];
        $client->types = ['salesinvoice', 'salescreditnote', 'purchaseinvoice', 'purchasecreditnote'];

        return $client->getAll();
    }
}
