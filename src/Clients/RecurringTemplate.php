<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\PaginationClient;

class RecurringTemplate extends PaginationClient
{
    use GetTrait;

    protected string $resource = 'recurring-templates';
}
