<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\VoucherListTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;

class Invoice extends BaseClient
{
    use GetTrait;
    use VoucherListTrait;
    use DocumentClientTrait;
    use CreateFinalizeTrait;

    protected string $resource = 'invoices';
    protected array $voucherListTypes = ['invoice'];
}
