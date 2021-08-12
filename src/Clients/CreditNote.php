<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetAllVoucherListTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;

class CreditNote extends BaseClient
{
    use GetTrait;
    use CreateFinalizeTrait;
    use GetAllVoucherListTrait;
    use DocumentClientTrait;

    protected string $resource = 'credit-notes';

    protected array $getAllTypes = ['creditnote'];
}
