<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Voucherlist;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\PaginationClient;
use Psr\Http\Message\ResponseInterface;

class Client extends PaginationClient
{
    protected string $resource = 'voucherlist';

    public string $sortColumn = 'voucherNumber';
    public string $sortDirection = 'DESC';

    /** @var string[] */
    public array $types = [];

    /** @var string[] */
    public array $statuses = [];

    /**
     * @return $this
     */
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

        return $this;
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
     * @param array[] $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function create(array $data): ResponseInterface
    {
        throw new BadMethodCallException('method create is not supported for ' . $this->resource);
    }

    /**
     * @param string $id
     * @param array[] $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        throw new BadMethodCallException('method update is not supported for ' . $this->resource);
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function get(string $id): ResponseInterface
    {
        throw new BadMethodCallException('method get is not supported for ' . $this->resource);
    }
}
