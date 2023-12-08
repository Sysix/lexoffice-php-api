<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\GetTrait;

class Payment extends BaseClient
{
    use GetTrait;

    protected string $resource = 'payment';
}
