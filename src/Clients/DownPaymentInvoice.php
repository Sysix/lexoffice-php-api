<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetAllVoucherListTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;

class DownPaymentInvoice extends BaseClient
{
    use GetTrait;
    use GetAllVoucherListTrait;
    use DocumentClientTrait;

    protected string $resource = 'down-payment-invoices';
    protected array $getAllTypes = ['downpaymentinvoice'];
}
