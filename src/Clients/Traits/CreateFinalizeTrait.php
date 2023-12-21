<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Utils;

trait CreateFinalizeTrait
{
    /**
     * @param mixed[] $data
     */
    public function create(array $data, bool $finalized = false): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource . ($finalized ? '?finalize=true' : ''));

        $api->setRequest($api->getRequest()->withBody(Utils::createStream($data)));

        return $api->getResponse();
    }
}
