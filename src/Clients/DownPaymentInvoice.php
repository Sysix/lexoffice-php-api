<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Clients\Traits\VoucherListTrait;

class DownPaymentInvoice extends BaseClient
{
    use GetTrait;
    use VoucherListTrait;
    use DocumentClientTrait;

    protected string $resource = 'down-payment-invoices';

    /** @var string[] */
    protected array $voucherListTypes = ['downpaymentinvoice'];
}
