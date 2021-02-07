<?php

namespace Clicksports\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait UpdateTrait
{
    /**
     * @param string $id
     * @param array[] $data
     * @return ResponseInterface
     */
    public function update(string $id, array $data): ResponseInterface
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . $id);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}