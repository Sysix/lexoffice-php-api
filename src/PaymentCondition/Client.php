<?php


namespace Clicksports\LexOffice\PaymentCondition;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'payment-conditions';

    /***
     * @param array $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function create(array $data): ResponseInterface
    {
        throw new BadMethodCallException('method create is defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function get(string $id): ResponseInterface
    {
        throw new BadMethodCallException('method get is defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @param array $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
