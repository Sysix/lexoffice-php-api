<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Country extends BaseClient
{
    protected string $resource = 'countries';

    /**
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
