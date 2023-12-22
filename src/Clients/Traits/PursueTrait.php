<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Utils;

trait PursueTrait
{
    /**
     * @param mixed[] $data
     */
    public function pursue(string $precedingSalesVoucherId, array $data): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource . '?precedingSalesVoucherId=' . rawurlencode($precedingSalesVoucherId));

        $api->setRequest($api->getRequest()->withBody(Utils::createStream($data)));

        return $api->getResponse();
    }
}
