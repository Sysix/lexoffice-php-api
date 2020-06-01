<?php


namespace Clicksports\LexOffice\Event;

use Clicksports\LexOffice\BaseClient;
use BadMethodCallException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;
use function GuzzleHttp\Psr7\stream_for;

class Client extends BaseClient
{

    /**
     * @param array $data
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function create(array $data)
    {
        $api = $this->api->newRequest('POST', 'event-subscriptions');

        $api->request = $api->request->withBody(stream_for(
            json_encode($data)
        ));

        return $api->getResponse();
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
    public function get(string $id)
    {
        return $this->api->newRequest('GET', 'event-subscriptions/' . $id)
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
