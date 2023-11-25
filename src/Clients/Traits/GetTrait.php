<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait GetTrait
{
    /**
     * @param string $id
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function get(string $id): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource . '/' . $id)
            ->getResponse();
    }
}