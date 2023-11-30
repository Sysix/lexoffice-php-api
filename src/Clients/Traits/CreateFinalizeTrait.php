<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait CreateFinalizeTrait
{
    /**
     * @param mixed[] $data
     */
    public function create(array $data, bool $finalized = false): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource . ($finalized ? '?finalize=true' : ''));

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}