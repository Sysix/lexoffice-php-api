<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\Clients\Traits\CreateTrait;
use Clicksports\LexOffice\Clients\Traits\GetTrait;
use Clicksports\LexOffice\PaginationClient;

class Contact extends PaginationClient
{
    use CreateTrait;
    use GetTrait;

    protected string $resource = 'contacts';

    public string $sortDirection = 'ASC';

    public string $sortProperty = 'name';

    /**
     * @param int $page
     * @return string
     */
    public function generateUrl(int $page): string
    {
        return parent::generateUrl($page) .
            '&direction=' . $this->sortDirection .
            '&property=' .$this->sortProperty;
    }
}
