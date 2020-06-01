<?php


namespace Clicksports\LexOffice;

use Psr\Http\Message\ResponseInterface;

abstract class BaseClient implements ClientInterface
{
    /**
     * @var Api $api
     */
    protected Api $api;

    public function __construct(Api $lexOffice)
    {
        $this->api = $lexOffice;
    }

    /**
     * @param ResponseInterface $response
     * @return object
     */
    function getAsJson(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();

        return \GuzzleHttp\json_decode($body);
    }
}
