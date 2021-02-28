<?php

namespace Clicksports\LexOffice\Payment;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'payment';

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
     * @param array $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @throws BadMethodCallException
     */
    public function getAll(): ResponseInterface
    {
        throw new BadMethodCallException('method getAll is defined for ' . $this->resource);
    }
}
