<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;
use stdClass;
use Sysix\LexOffice\Clients\File;
use Sysix\LexOffice\Utils;

trait DocumentClientTrait
{
    public function document(string $id, bool $asContent = false, string $acceptHeader = '*/*'): ResponseInterface
    {
        $response = $this->api
            ->newRequest('GET', $this->resource . '/' . rawurlencode($id) . '/document')
            ->getResponse();

        if ($asContent === false) {
            return $response;
        }

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        $content = Utils::getJsonFromResponse($response);

        if ($content === null || !is_object($content) || !property_exists($content, 'documentFileId') || !is_string($content->documentFileId)) {
            return $response;
        }

        $fileClient = new File($this->api);

        return $fileClient->get($content->documentFileId, $acceptHeader);
    }
}
