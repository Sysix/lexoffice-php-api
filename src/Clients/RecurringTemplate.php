<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Exceptions\BadMethodCallException;
use Sysix\LexOffice\PaginationClient;

class RecurringTemplate extends PaginationClient
{
    use GetTrait;

    protected string $resource = 'recurring-templates';
}
