<?php

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class DownPaymentInvoice extends BaseClient
{
    use GetTrait;
    use DocumentClientTrait;

    protected string $resource = 'down-payment-invoices';

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        $client = new VoucherList($this->api);

        $client->setToEverything();
        $client->types = ['downpaymentinvoice'];

        return $client->getAll();
    }
}
