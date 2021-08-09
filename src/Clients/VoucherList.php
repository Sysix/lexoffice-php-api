<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\PaginationClient;

class VoucherList extends PaginationClient
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
    public function setToEverything(): self
    {
        $this->types = [
            'salesinvoice',
            'salescreditnote',
            'purchaseinvoice',
            'purchasecreditnote',
            'invoice',
            'downpaymentinvoice',
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
}
