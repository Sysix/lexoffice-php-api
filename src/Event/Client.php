<?php


namespace Clicksports\LexOffice\Event;

use Clicksports\LexOffice\BaseClient;
use BadMethodCallException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;
class Client extends BaseClient
{
    protected string $resource = 'event-subscriptions';

    public function get(string $id)
    {
        throw new BadMethodCallException('method get() is not supported');
    }

    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update() is not implemented yet');
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getAll()
    {
        return $this->api->newRequest('GET', 'event-subscriptions')
            ->getResponse();
    }
    /**
     * @param string $id
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function delete(string $id)
    {
        return $this->api->newRequest('DELETE', 'event-subscriptions/' . $id)
            ->getResponse();
    }
}
