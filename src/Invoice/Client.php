<?php

namespace Clicksports\LexOffice\Invoice;

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
     * @param bool $finalized
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function create(array $data, $finalized = false)
    {
        $api = $this->api->newRequest('POST', 'invoices' . ($finalized ? '?finalize=true' : ''));

        $api->request = $api->request->withBody(stream_for(
            json_encode($data)
        ));

        return $api->getResponse();
    }

    /**
     * @param string $id
     * @param array $data
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function update(string $id, array $data)
    {
        $api = $this->api->newRequest('PUT', 'invoices/' . $id);

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

        $client->setToEverything();
        $client->types = ['invoice'];

        return $client->getAll();
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function get(string $id)
    {
        return $this->api->newRequest('GET', 'invoices/' . $id)
            ->getResponse();
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function delete(string $id)
    {
        throw new BadMethodCallException('method delete is defined for invoices');
    }
}
