<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Traits\DocumentClientTrait;
use Psr\Http\Message\ResponseInterface;

class OrderConfirmation extends BaseClient
{
    use DocumentClientTrait;

    protected string $resource = 'order-confirmations';

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        $client = new VoucherList($this->api);

        $client->setToEverything();
        $client->types = ['orderconfirmation'];

        return $client->getAll();
    }
}
