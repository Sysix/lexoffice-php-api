<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Psr\Http\Message\ResponseInterface;

class Profile extends BaseClient
{
    protected string $resource = 'profile';

    public function get(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
