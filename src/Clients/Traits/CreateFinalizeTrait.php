<?php

namespace Clicksports\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait CreateFinalizeTrait
{
    /**
     * @param array[] $data
     * @param bool $finalized
     * @return ResponseInterface
     */
    public function create(array $data, $finalized = false): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource . ($finalized ? '?finalize=true' : ''));

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}