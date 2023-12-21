<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Utils;

trait UpdateTrait
{
    /**
     * @param mixed[] $data
     */
    public function update(string $id, array $data): ResponseInterface
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . rawurlencode($id));

        $api->setRequest($api->getRequest()->withBody(Utils::createStream($data)));

        return $api->getResponse();
    }
}
