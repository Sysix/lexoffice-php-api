<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateTrait;
use Sysix\LexOffice\Clients\Traits\DocumentClientTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\VoucherListTrait;

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
