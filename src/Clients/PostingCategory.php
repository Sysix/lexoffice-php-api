<?php declare(strict_types=1);

namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class PostingCategory extends BaseClient
{
    protected string $resource = 'posting-categories';

    /**
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
