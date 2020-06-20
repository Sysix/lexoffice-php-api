<?php

namespace Clicksports\LexOffice\OrderConfirmation;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use BadMethodCallException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;

class Client extends BaseClient
{
    protected string $resource = 'order-confirmations';


    /**
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws InvalidArgumentException
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
