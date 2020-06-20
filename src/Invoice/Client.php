<?php

namespace Clicksports\LexOffice\Invoice;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;

class Client extends BaseClient
{
    protected string $resource = 'invoices';
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
        $oldResource = $this->resource;

        $this->resource .= $finalized ? '?finalize=true' : '';
        $response = parent::create($data);
        $this->resource = $oldResource;

        return $response;
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
}
