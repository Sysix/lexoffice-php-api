<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\BaseClient;

class PaymentCondition extends BaseClient
{
    protected string $resource = 'payment-conditions';

    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
