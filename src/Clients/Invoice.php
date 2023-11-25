<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\VoucherListTrait;

class Invoice extends BaseClient
{
    use GetTrait;
    use VoucherListTrait;
    use DocumentClientTrait;
    use CreateFinalizeTrait;

    protected string $resource = 'invoices';

    /** @var string[] */
    protected array $voucherListTypes = ['invoice'];
}
