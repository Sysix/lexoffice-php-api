<?php

namespace Clicksports\LexOffice\RecurringTemplate;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\PaginationClient;

class Client extends PaginationClient
{
    protected string $resource = 'recurring-templates';

    /**
     * @param array $data
     * @param bool $finalized
     * @throws BadMethodCallException
     */
    public function create(array $data, $finalized = false)
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
