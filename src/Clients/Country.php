<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\BaseClient;

class Country extends BaseClient
{
    protected string $resource = 'countries';

    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
