<?php

namespace Clicksports\LexOffice\DownPaymentInvoice;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    use DocumentClientTrait;

    protected string $resource = 'down-payment-invoices';

    /**
     * @param array $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function create(array $data): ResponseInterface
    {
        throw new BadMethodCallException('method create is defined for ' . $this->resource);
    }


    /**
     * @param string $id
     * @param array $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        $client = new VoucherlistClient($this->api);

        $client->setToEverything();
        $client->types = ['downpaymentinvoice'];

        return $client->getAll();
    }
}
