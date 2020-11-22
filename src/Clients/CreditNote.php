<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Traits\DocumentClientTrait;
use Psr\Http\Message\ResponseInterface;

class CreditNote extends BaseClient
{
    use DocumentClientTrait;

    protected string $resource = 'credit-notes';

    /**
     * @param array[] $data
     * @param bool $finalized
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function create(array $data, $finalized = false): ResponseInterface
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
    public function getAll(): ResponseInterface
    {
        $client = new VoucherList($this->api);

        $client->setToEverything();
        $client->types = ['creditnote'];

        return $client->getAll();
    }
}
