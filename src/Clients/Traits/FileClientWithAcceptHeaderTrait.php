<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait FileClientWithAcceptHeaderTrait
{
    public function file(string $id, string $acceptHeader = '*/*'): ResponseInterface
    {
        $this->api->newRequest('GET', $this->resource . '/' . rawurlencode($id) . '/file');

        return $this->api
            ->setRequest($this->api->getRequest()->withHeader('Accept', $acceptHeader))
            ->getResponse();
    }
}
