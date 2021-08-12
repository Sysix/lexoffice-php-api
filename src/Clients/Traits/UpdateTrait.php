<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients\Traits;

use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait UpdateTrait
{
    /**
     * @param string $id
     * @param array[] $data
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