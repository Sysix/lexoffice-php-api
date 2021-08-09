<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;

class Payment extends BaseClient
{
    use GetTrait;

    protected string $resource = 'payment';
}
