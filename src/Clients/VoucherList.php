<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\PaginationClient;
use DateTimeInterface;
use Psr\Http\Message\ResponseInterface;

class VoucherList extends PaginationClient
{
    protected string $resource = 'voucherlist';

    public string $sortColumn = 'voucherNumber';
    public string $sortDirection = 'DESC';

    /** @var string[] */
    public array $types = [];

    /** @var string[] */
    public array $statuses = [];

    public ?bool $archived = null;

    public ?string $contactId = null;

    public ?DateTimeInterface $voucherDateFrom = null;

    public ?DateTimeInterface $voucherDateTo = null;

    public ?DateTimeInterface $createdDateFrom = null;

    public ?DateTimeInterface $createdDateTo = null;

    public ?DateTimeInterface $updatedDateFrom = null;

    public ?DateTimeInterface $updatedDateTo = null;

    /**
     * @deprecated 1.0 Not recommend anymore because of Rate Limiting, WILL be removed in 2.0
     */
    public function setToEverything(): self
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_WARNING);

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

    public function generateUrl(int $page): string
    {
        $dateFormat = DateTimeInterface::ATOM;

        return parent::generateUrl($page) .
            '&sort=' . $this->sortColumn . ',' . $this->sortDirection .
            '&voucherType=' . implode(',', $this->types) .
            '&voucherStatus=' . implode(',', $this->statuses) .
            ($this->archived !== null ? '&archived=' . $this->archived : '') .
            ($this->contactId !== null ? '&contactId=' . $this->contactId : '') .
            ($this->voucherDateFrom !== null ? '&voucherDateFrom=' . $this->voucherDateFrom->format($dateFormat) : '') .
            ($this->voucherDateTo !== null ? '&voucherDateTo=' . $this->voucherDateTo->format($dateFormat) : '') .
            ($this->createdDateFrom !== null ? '&createdDateFrom=' . $this->createdDateFrom->format($dateFormat) : '') .
            ($this->createdDateTo !== null ? '&createdDateTo=' . $this->createdDateTo->format($dateFormat) : '') .
            ($this->updatedDateFrom !== null ? '&updatedDateFrom=' . $this->updatedDateFrom->format($dateFormat) : '') .
            ($this->updatedDateTo !== null ? '&updatedDateTo=' . $this->updatedDateTo->format($dateFormat) : '');
    }
}
