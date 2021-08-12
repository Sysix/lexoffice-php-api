<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\Clients\Traits\VoucherListTrait;

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
