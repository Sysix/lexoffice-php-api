<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait UpdateTrait
{
    /**
     * @param string $id
     * @param mixed[] $data
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        $api = $this->api->newRequest('PUT', $this->resource . '/' . $id);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }
}