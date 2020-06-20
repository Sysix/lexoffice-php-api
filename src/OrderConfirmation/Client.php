<?php

namespace Clicksports\LexOffice\OrderConfirmation;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'order-confirmations';


    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        $client->setToEverything();
        $client->types = ['orderconfirmation'];

        return $client->getAll();
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     * @noinspection PhpUnusedParameterInspection
     */
    public function document(string $id)
    {
        throw new BadMethodCallException('method document() is not implemented yet');
    }
}
