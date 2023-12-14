<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateTrait;
use Sysix\LexOffice\Clients\Traits\DeleteTrait;
use Psr\Http\Message\ResponseInterface;

class Event extends BaseClient
{
    use CreateTrait;
    use DeleteTrait;

    protected string $resource = 'event-subscriptions';

    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
