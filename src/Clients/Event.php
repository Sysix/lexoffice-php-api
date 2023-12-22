<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateTrait;
use Sysix\LexOffice\Clients\Traits\DeleteTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;

class Event extends BaseClient
{
    use CreateTrait;
    use DeleteTrait;
    use GetTrait;

    protected string $resource = 'event-subscriptions';

    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
