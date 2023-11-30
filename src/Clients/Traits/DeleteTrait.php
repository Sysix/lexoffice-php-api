<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

trait DeleteTrait
{

    public function delete(string $id): ResponseInterface
    {
        return $this->api->newRequest('DELETE', $this->resource . '/' . $id)
            ->getResponse();
    }
}