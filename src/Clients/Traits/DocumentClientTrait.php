<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Clients\File;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use Sysix\LexOffice\Utils;

trait DocumentClientTrait
{
    public function document(string $id, bool $asContent = false): ResponseInterface
    {
        $response = $this->api->newRequest('GET', $this->resource . '/' . $id . '/document')
            ->getResponse();

        if ($asContent === false) {
            return $response;
        }

        if ($response->getStatusCode() !== 200) {
            return $response;
        }

        /** @var ?stdClass{documentField: string} $content */
        $content = Utils::getJsonFromResponse($response);

        if ($content === null) {
            return $response;
        }

        $fileClient = new File($this->api);

        return $fileClient->get($content->documentFileId);
    }
}