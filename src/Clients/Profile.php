<?php declare(strict_types=1);


namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Profile extends BaseClient
{
    protected string $resource = 'profile';

    /**
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function get(): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource)
            ->getResponse();
    }
}
