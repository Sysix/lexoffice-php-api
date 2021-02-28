<?php

namespace Clicksports\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait CreateTrait
{
    /**
     * @param array[] $data
     * @return ResponseInterface
     */
    public function create(array $data): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}