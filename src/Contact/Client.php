<?php

namespace Clicksports\LexOffice\Contact;

use Clicksports\LexOffice\PaginationClient;

class Client extends PaginationClient
{
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

    /**
    * @param string $id
    * @param array $data
    * @return ResponseInterface
    * @throws CacheException
    * @throws LexOfficeApiException
    */
    public function update(string $id, array $data)
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . $id);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}
