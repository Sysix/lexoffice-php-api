<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Clients\VoucherList;

trait VoucherListTrait
{
    /**
     * @deprecated 1.0 Not recommend anymore because of Rate Limiting, WILL be removed in 2.0
     */
    public function getPage(int $page): ResponseInterface
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

        $client = new VoucherList($this->api);
        $client->setToEverything();
        $client->types = $this->voucherListTypes;

        return $client->getPage($page);
    }

    /**
     * @deprecated 1.0 Not recommend anymore because of Rate Limiting, WILL be removed in 2.0
     */
    public function getAll(): ResponseInterface
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

        $client = new VoucherList($this->api);
        $client->setToEverything();
        $client->types = $this->voucherListTypes;

        return $client->getAll();
    }

    public function getVoucherListClient(): VoucherList
    {
        $client = new VoucherList($this->api);
        $client->types = $this->voucherListTypes;

        return $client;
    }
}
