<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Clients\Traits\VoucherListTrait;

class OrderConfirmation extends BaseClient
{
    use GetTrait;
    use VoucherListTrait;
    use CreateTrait;
    use DocumentClientTrait;

    protected string $resource = 'order-confirmations';

    /** @var string[] */
    protected array $voucherListTypes = ['orderconfirmation'];
}
