<?php declare(strict_types=1);


namespace Clicksports\LexOffice\Clients;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Event extends BaseClient
{
    protected string $resource = 'event-subscriptions';

    public function get(string $id): ResponseInterface
    {
        throw new BadMethodCallException('method get() is not supported');
    }

    /**
     * @param string $id
     * @param array[] $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        throw new BadMethodCallException('method update() is not implemented yet');
    }

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

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws CacheException
     * @throws LexOfficeApiException
     */
    public function delete(string $id): ResponseInterface
    {
        return $this->api->newRequest('DELETE', 'event-subscriptions/' . $id)
            ->getResponse();
    }
}
