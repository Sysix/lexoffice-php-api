<?php

namespace Clicksports\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait GetTrait
{
    /**
     * @param string $id
     * @return ResponseInterface
     */
    public function get(string $id): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource . '/' . $id)
            ->getResponse();
    }
}