<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\PaginationClient;
use DateTimeInterface;

class VoucherList extends PaginationClient
{
    protected string $resource = 'voucherlist';

    public string $sortColumn = 'voucherNumber';

    /** @var string[] $types */
    public array $types;

    /** @var string[] $statuses */
    public array $statuses;

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
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

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
            // 'overdue',
            'accepted',
            'rejected'
        ];

        return $this;
    }

    protected function buildQueryParams(array $params): string
    {
        $dateFormat = DateTimeInterface::ATOM;

        $params['voucherType'] = implode(',', $this->types);
        $params['voucherStatus'] = implode(',', $this->statuses);
        $params['archived'] = $this->archived;
        $params['voucherDateFrom'] = $this->voucherDateFrom?->format($dateFormat);
        $params['voucherDateTo'] = $this->voucherDateTo?->format($dateFormat);
        $params['createdDateFrom'] = $this->createdDateFrom?->format($dateFormat);
        $params['createdDateTo'] = $this->createdDateTo?->format($dateFormat);
        $params['updatedDateFrom'] = $this->updatedDateFrom?->format($dateFormat);
        $params['updatedDateTo'] = $this->updatedDateTo?->format($dateFormat);

        return parent::buildQueryParams($params);
    }
}
