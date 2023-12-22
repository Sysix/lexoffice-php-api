<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\VoucherListTrait;

class Quotation extends BaseClient
{
    use CreateFinalizeTrait;
    use DocumentClientTrait;
    use GetTrait;
    use VoucherListTrait;

    protected string $resource = 'quotations';

    /** @var string[] */
    protected array $voucherListTypes = ['quotation'];
}
