<?php

namespace Clicksports\LexOffice\Clients\Traits;

use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait CreateFinalizeTrait
{
    /**
     * @param array[] $data
     * @param bool $finalized
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function create(array $data, bool $finalized = false): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource . ($finalized ? '?finalize=true' : ''));

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}