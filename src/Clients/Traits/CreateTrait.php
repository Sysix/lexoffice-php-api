<?php declare(strict_types=1);

namespace Clicksports\LexOffice\Clients\Traits;

use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait CreateTrait
{
    /**
     * @param array[] $data
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