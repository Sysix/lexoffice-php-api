<?php

namespace Clicksports\LexOffice\Voucherlist;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\PaginationClient;

class Client extends PaginationClient
{
    protected string $resource = 'voucherlist';

    public string $sortColumn = 'voucherNumber';
    public string $sortDirection = 'DESC';

    public array $types = [];

    public array $statuses = [];

    public function setToEverything()
    {
        $this->types = [
            'salesinvoice',
            'salescreditnote',
            'purchaseinvoice',
            'purchasecreditnote',
            'invoice',
            'creditnote',
            'orderconfirmation',
            'quotation'
        ];

        $this->statuses = [
            'draft',
            'open',
            'paid',
            'paidoff',
            'voided',
            //'overdue',
            'accepted',
            'rejected'
        ];
    }

    /**
     * @param int $page
     * @return string
     */
    public function generateUrl(int $page): string
    {
        return parent::generateUrl($page) .
            '&sort=' . $this->sortColumn . ',' . $this->sortDirection .
            '&voucherType=' . implode(',', $this->types) .
            '&voucherStatus=' . implode(',', $this->statuses);
    }

    /**
     * @param array $data
     * @throws BadMethodCallException
     */
    public function create(array $data)
    {
        throw new BadMethodCallException('method create is not supported for ' . $this->resource);
    }

    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update is not supported for ' . $this->resource);
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function get(string $id)
    {
        throw new BadMethodCallException('method get is not supported for ' . $this->resource);
    }
}
