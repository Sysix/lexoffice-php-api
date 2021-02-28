<?php

namespace Clicksports\LexOffice\Payment;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\Traits\DocumentClientTrait;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    protected string $resource = 'payment';

    /***
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
     * @throws BadMethodCallException
     */
    public function getAll()
    {
        throw new BadMethodCallException('method getAll is defined for ' . $this->resource);
    }
}
