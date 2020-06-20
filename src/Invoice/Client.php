<?php

namespace Clicksports\LexOffice\Invoice;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'invoices';

    /**
     * @param array $data
     * @param bool $finalized
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
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
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        $client->setToEverything();
        $client->types = ['invoice'];

        return $client->getAll();
    }
}
