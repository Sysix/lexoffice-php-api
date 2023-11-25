<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait CreateFinalizeTrait
{
    /**
     * @param mixed[] $data
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