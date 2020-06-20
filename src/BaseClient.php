<?php


namespace Clicksports\LexOffice;

use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\stream_for;
use function json_decode;

abstract class BaseClient implements ClientInterface
{
    protected string $resource;
    /**
     * @var Api $api
     */
    protected Api $api;

    public function __construct(Api $lexOffice)
    {
        $this->api = $lexOffice;
    }

    /**
     * @param array $data
     * @return ResponseInterface
     * @throws Exceptions\CacheException
     * @throws Exceptions\LexOfficeApiException
     */
    public function create(array $data)
    {
        $api = $this->api->newRequest('POST', $this->resource);

        $api->request = $api->request->withBody(stream_for(
            json_encode($data)
        ));

        return $api->getResponse();
    }

    /**
     * @param string $id
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function update(string $id, array $data)
    {
        throw new Exceptions\BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws Exceptions\CacheException
     * @throws Exceptions\LexOfficeApiException
     */
    public function get(string $id)
    {
        return $this->api->newRequest('GET', $this->resource . '/' . $id)
            ->getResponse();
    }

    /**
     * @param ResponseInterface $response
     * @return object
     */
    public function getAsJson(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();

        return json_decode($body);
    }
}
