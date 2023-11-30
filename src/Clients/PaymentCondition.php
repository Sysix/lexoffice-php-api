<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Psr\Http\Message\ResponseInterface;

class PaymentCondition extends BaseClient
{
    protected string $resource = 'payment-conditions';

    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
