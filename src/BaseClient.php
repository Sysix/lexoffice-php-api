<?php


namespace Clicksports\LexOffice;

use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use GuzzleHttp\Psr7\MultipartStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use function GuzzleHttp\Psr7\stream_for;

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
     * @param array[] $data
     * @return ResponseInterface
     * @throws Exceptions\CacheException
     * @throws Exceptions\LexOfficeApiException
     */
    public function create(array $data): ResponseInterface
    {
        $api = $this->api->newRequest('POST', $this->resource);

        $api->request = $api->request->withBody($this->createStream($data));

        return $api->getResponse();
    }

    /**
     * @param string $id
     * @param array[] $data
     * @return ResponseInterface
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data): ResponseInterface
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws Exceptions\CacheException
     * @throws Exceptions\LexOfficeApiException
     */
    public function get(string $id): ResponseInterface
    {
        return $this->api->newRequest('GET', $this->resource . '/' . $id)
            ->getResponse();
    }

    /**
     * @param ResponseInterface $response
     * @return object
     */
    public function getAsJson(ResponseInterface $response): object
    {
        $body = $response->getBody()->__toString();

        return \GuzzleHttp\json_decode($body);
    }

    /**
     * @param array[] $content
     * @return StreamInterface
     */
    public function createStream(array $content): StreamInterface
    {
        return stream_for(\GuzzleHttp\json_encode($content));
    }

    /**
     * @param string[]|bool[]|resource[] $content
     * @return MultipartStream
     */
    public function createMultipartStream(array $content): MultipartStream
    {
        $stream = [];

        foreach ($content as $key => $value) {
            $stream[] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        return new MultipartStream($stream);
    }
}
