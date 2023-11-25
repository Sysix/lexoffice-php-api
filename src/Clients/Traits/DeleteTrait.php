<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

trait DeleteTrait
{
    /**
     * @param string $id
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function delete(string $id): ResponseInterface
    {
        return $this->api->newRequest('DELETE', $this->resource . '/' . $id)
            ->getResponse();
    }
}