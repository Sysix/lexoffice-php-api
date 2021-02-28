<?php

namespace Clicksports\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait DeleteTrait
{
    /**
     * @param string $id
     * @return ResponseInterface
     */
    public function delete(string $id): ResponseInterface
    {
        return $this->api->newRequest('DELETE', $this->resource . '/' . $id)
            ->getResponse();
    }
}