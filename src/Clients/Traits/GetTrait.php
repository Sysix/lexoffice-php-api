<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait GetTrait
{
    public function get(string $id): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource . '/' . rawurlencode($id))
            ->getResponse();
    }
}
