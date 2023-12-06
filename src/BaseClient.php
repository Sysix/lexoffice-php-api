<?php declare(strict_types=1);


namespace Sysix\LexOffice;

use GuzzleHttp\Psr7\MultipartStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class BaseClient implements ClientInterface
{
    protected string $resource;

    public function __construct(
        protected Api $api
        )
    {
    }

    public function getAsJson(ResponseInterface $response): object
    {
        $body = $response->getBody()->__toString();

        return Utils::jsonDecode($body);
    }

    protected function createStream(mixed $content): StreamInterface
    {
        return Utils::streamFor(
            Utils::jsonEncode($content)
        );
    }

    /**
     * @param array<string, string|bool|resource> $content
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
