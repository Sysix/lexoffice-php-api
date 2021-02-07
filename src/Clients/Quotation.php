<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Quotation extends BaseClient
{
    use GetTrait;
    use DocumentClientTrait;
    use CreateFinalizeTrait;

    protected string $resource = 'quotations';

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        $client = new VoucherList($this->api);

        $client->setToEverything();
        $client->types = ['quotation'];

        return $client->getAll();
    }
}
