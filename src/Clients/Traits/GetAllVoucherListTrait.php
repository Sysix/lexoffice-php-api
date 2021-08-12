<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients\Traits;

use Clicksports\LexOffice\Clients\VoucherList;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait GetAllVoucherListTrait
{
    /**
     * @param string[] $states
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function getAll(array $states = []): ResponseInterface
    {
        $client = new VoucherList($this->api);

        if (!$states) {
            $client->setToEverything();
        } else {
            $client->statuses = $states;
        }
        $client->types = $this->getAllTypes;

        return $client->getAll();
    }
}