<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetAllVoucherListTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;

class OrderConfirmation extends BaseClient
{
    use GetTrait;
    use GetAllVoucherListTrait;
    use CreateTrait;
    use DocumentClientTrait;

    protected string $resource = 'order-confirmations';
    protected array $getAllTypes = ['orderconfirmation'];
}
