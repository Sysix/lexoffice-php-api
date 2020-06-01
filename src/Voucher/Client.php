<?php

namespace Clicksports\LexOffice\Voucher;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use BadMethodCallException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;
use function GuzzleHttp\Psr7\stream_for;

class Client extends BaseClient
{
    /**
     * @param array $data
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function create(array $data)
    {
        $api = $this->api->newRequest('POST', 'vouchers');

        $api->request = $api->request->withBody(stream_for(
            json_encode($data)
        ));

        return $api->getResponse();
    }

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
        $api = $this->api->newRequest('PUT', 'vouchers/' . $id);

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

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws GuzzleException
     */
    public function get(string $id)
    {
        return $this->api->newRequest('GET', 'vouchers/' . $id)
            ->getResponse();
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function delete(string $id)
    {
        throw new BadMethodCallException('method delete is defined for vouchers');
    }
}
