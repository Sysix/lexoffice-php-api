<?php declare(strict_types=1);


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
     * @param ResponseInterface $response
     * @return object
     */
    public function getAsJson(ResponseInterface $response): object
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
     * @param string[]|bool[]|resource[] $content
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
