<?php


namespace Clicksports\LexOffice\Country;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'countries';

    /**
     * @param array $data
     * @throws BadMethodCallException
     */
    public function create(array $data)
    {
        throw new BadMethodCallException('method create is not defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function get(string $id)
    {
        throw new BadMethodCallException('method get is not defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update is not defined for ' . $this->resource);
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
