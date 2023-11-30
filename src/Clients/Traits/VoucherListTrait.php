<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Clients\VoucherList;
use Psr\Http\Message\ResponseInterface;

trait VoucherListTrait
{
    /**
     * @param string[] $states
     */
    public function getPage(int $page, array $states = []): ResponseInterface
    {
        $client = new VoucherList($this->api);
        $client->types = $this->voucherListTypes;

        if (!$states) {
            $client->setToEverything();
        } else {
            $client->statuses = $states;
        }

        return $client->getPage($page);
    }

    /**
     * @param string[] $states
     */
    public function getAll(array $states = []): ResponseInterface
    {
        $client = new VoucherList($this->api);
        $client->types = $this->voucherListTypes;

        if (!$states) {
            $client->setToEverything();
        } else {
            $client->statuses = $states;
        }

        return $client->getAll();
    }
}