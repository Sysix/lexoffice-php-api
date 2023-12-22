<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Utils;

trait PursueFinalizeTrait
{
    /**
     * @param mixed[] $data
     */
    public function pursue(string $precedingSalesVoucherId, array $data, bool $finalized = false): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource . '?precedingSalesVoucherId=' . rawurlencode($precedingSalesVoucherId) . ($finalized ? '&finalize=true' : ''));

        $api->setRequest($api->getRequest()->withBody(Utils::createStream($data)));

        return $api->getResponse();
    }
}
