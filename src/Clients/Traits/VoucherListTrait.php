<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients\Traits;

use Clicksports\LexOffice\Clients\VoucherList;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait VoucherListTrait
{
    /**
     * @param int $page
     * @param string[] $states
     * @return ResponseInterface
     * @throws LexOfficeApiException
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
     * @return ResponseInterface
     * @throws LexOfficeApiException
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