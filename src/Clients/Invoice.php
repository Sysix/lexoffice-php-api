<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\PursueFinalizeTrait;
use Sysix\LexOffice\Clients\Traits\VoucherListTrait;

class Invoice extends BaseClient
{
    use CreateFinalizeTrait;
    use DocumentClientTrait;
    use GetTrait;
    use PursueFinalizeTrait;
    use VoucherListTrait;

    protected string $resource = 'invoices';

    /** @var string[] */
    protected array $voucherListTypes = ['invoice'];
}
