<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\VoucherListTrait;

class CreditNote extends BaseClient
{
    use GetTrait;
    use CreateFinalizeTrait;
    use VoucherListTrait;
    use DocumentClientTrait;

    protected string $resource = 'credit-notes';

    /** @var string[] */
    protected array $voucherListTypes = ['creditnote'];
}
