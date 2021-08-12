<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateFinalizeTrait;
use Clicksports\LexOffice\Clients\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Clients\Traits\GetAllVoucherListTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;

class Quotation extends BaseClient
{
    use GetTrait;
    use GetAllVoucherListTrait;
    use DocumentClientTrait;
    use CreateFinalizeTrait;

    protected string $resource = 'quotations';
    protected array $getAllTypes = ['quotation'];
}
