<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\VoucherListTrait;

class DownPaymentInvoice extends BaseClient
{
    use DocumentClientTrait;
    use GetTrait;
    use VoucherListTrait;

    protected string $resource = 'down-payment-invoices';

    /** @var string[] */
    protected array $voucherListTypes = ['downpaymentinvoice'];
}
