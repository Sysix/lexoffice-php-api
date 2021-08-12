<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\VoucherListTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;

class DownPaymentInvoice extends BaseClient
{
    use GetTrait;
    use VoucherListTrait;
    use DocumentClientTrait;

    protected string $resource = 'down-payment-invoices';
    protected array $voucherListTypes = ['downpaymentinvoice'];
}
