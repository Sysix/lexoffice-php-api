<?php declare(strict_types=1);


namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Clients\Traits\CreateTrait;
use Clicksports\LexOffice\Clients\Traits\DeleteTrait;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Event extends BaseClient
{
    use DeleteTrait;
    use CreateTrait;

    protected string $resource = 'event-subscriptions';

    /**
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function getAll(): ResponseInterface
    {
        return $this->api->newRequest('GET', 'event-subscriptions')
            ->getResponse();
    }
}
