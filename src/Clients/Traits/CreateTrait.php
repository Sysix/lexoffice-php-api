<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait CreateTrait
{
    /**
     * @param mixed[] $data
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function create(array $data): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}