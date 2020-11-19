<?php


namespace Clicksports\LexOffice;

use GuzzleHttp\Psr7\MultipartStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

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

        $api->request = $api->request->withBody($this->createStream($data));

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

        if (class_exists('\GuzzleHttp\Utils', false)) {
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            return \GuzzleHttp\Utils::jsonDecode($body);
        }

        /**
         * fallback for guzzle 6
         *
         * @noinspection PhpDeprecationInspection
         */
        return \GuzzleHttp\json_decode($body);
    }

    /**
     * @param mixed $content
     * @return StreamInterface
     */
    protected function createStream($content): StreamInterface
    {
        if (class_exists('\GuzzleHttp\Utils', false)) {
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            return \GuzzleHttp\Psr7\Utils::streamFor(
                \GuzzleHttp\Utils::jsonEncode($content)
            );
        }


        /**
         * fallback for guzzle 6
         *
         * @noinspection PhpDeprecationInspection
         * @noinspection PhpFullyQualifiedNameUsageInspection
         */
        return \GuzzleHttp\Psr7\stream_for(
            \GuzzleHttp\json_encode($content)
        );
    }

    /**
     * @param array $content
     * @param string|null $boundary
     * @return MultipartStream
     */
    protected function createMultipartStream(array $content, string $boundary = null): MultipartStream
    {
        $stream = [];
        $boundary = $boundary ?: '--lexoffice';

        foreach ($content as $key => $value) {
            $stream[] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        return new MultipartStream($stream, $boundary);
    }
}
