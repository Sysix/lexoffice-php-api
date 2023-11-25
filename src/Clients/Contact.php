<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\Clients\Traits\CreateTrait;
use Sysix\LexOffice\Clients\Traits\GetTrait;
use Sysix\LexOffice\Clients\Traits\UpdateTrait;
use Sysix\LexOffice\PaginationClient;

class Contact extends PaginationClient
{
    use CreateTrait;
    use GetTrait;
    use UpdateTrait;

    protected string $resource = 'contacts';

    public string $sortDirection = 'ASC';

    public string $sortProperty = 'name';

    public ?int $number = null;

    public ?bool $customer = null;

    public ?bool $vendor = null;

    /**
     * @param int $page
     * @return string
     */
    public function generateUrl(int $page): string
    {
        return parent::generateUrl($page) .
            '&direction=' . $this->sortDirection .
            '&property=' . $this->sortProperty .
            ($this->number !== null ? '&number=' . $this->number : '' ) .
            ($this->customer !== null ? '&customer=' . $this->customer : '' ) .
            ($this->vendor !== null ? '&vendor=' . $this->vendor : '' );
    }
}
