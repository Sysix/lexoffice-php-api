<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\PursueTrait;

class Dunning extends BaseClient
{
    use DocumentClientTrait;
    use GetTrait;
    use PursueTrait;

    protected string $resource = 'dunnings';
}
