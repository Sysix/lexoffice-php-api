<?php

namespace Clicksports\LexOffice\Traits;

use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Clicksports\LexOffice\File\Client as FileClient;
use Psr\Http\Message\ResponseInterface;

trait DocumentClientTrait
{
    /**
     * @param string $id
     * @param bool $asContent
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function document(string $id, bool $asContent = false)
    {
        $response = $this->api->newRequest('GET', $this->resource . '/' . $id . '/document')
            ->getResponse();

        if ($asContent === false) {
            return $response;
        }

        $content = $this->getAsJson($response);
        $fileClient = new FileClient($this->api);

        return $fileClient->get($content->documentFileId);
    }
}