<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Utils;

trait CreateTrait
{
    /**
     * @param mixed[] $data
     */
    public function create(array $data): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource);

        $api->setRequest($api->getRequest()->withBody(Utils::createStream($data)));

        return $api->getResponse();
    }
}
