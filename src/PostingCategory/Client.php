<?php


namespace Clicksports\LexOffice\PostingCategory;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'posting-categories';

    /**
     * @param string|null $id (unused)
     * @throws BadMethodCallException
     */
    public function get(string $id = null)
    {
        throw new BadMethodCallException('method get is defined for ' . $this->resource);
    }

    /**
     * @param array $data
     * @throws BadMethodCallException
     */
    public function create(array $data)
    {
        throw new BadMethodCallException('method create is defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll()
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
