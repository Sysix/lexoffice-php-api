<?php

namespace Clicksports\LexOffice\Contact;

use Clicksports\LexOffice\PaginationClient;

class Client extends PaginationClient
{
    protected string $resource = 'contacts';

    public string $sortDirection = 'ASC';

    public string $sortProperty = 'name';

    public array $filters = [];

    /**
     * @param int $page
     * @return string
     */
    public function generateUrl(int $page): string
    {
        $params = array_merge(
            [
                'direction' => $this->sortDirection,
                'property' => $this->sortProperty
            ],
            $this->filters
        );
        return parent::generateUrl($page) . http_build_query($params);
    }
}
