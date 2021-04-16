<?php


namespace Clicksports\LexOffice\Profile;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'profile';

    /**
     * @param string|null $id (unused)
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function get(string $id = null)
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
    /**
     * @throws BadMethodCallException
     */
    public function getAll()
    {
        throw new BadMethodCallException('method getAll is not defined for ' . $this->resource);
    }

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
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update is not defined for ' . $this->resource);
    }
}
