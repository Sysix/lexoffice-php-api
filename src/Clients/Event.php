<?php declare(strict_types=1);


namespace Sysix\LexOffice\Clients;

use Sysix\LexOffice\BaseClient;
use Sysix\LexOffice\Clients\Traits\CreateTrait;
use Sysix\LexOffice\Clients\Traits\DeleteTrait;
use Sysix\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Event extends BaseClient
{
    use DeleteTrait;
    use CreateTrait;

    protected string $resource = 'event-subscriptions';

    /**
     * @return ResponseInterface
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', 'event-subscriptions')
            ->getResponse();
    }
}
