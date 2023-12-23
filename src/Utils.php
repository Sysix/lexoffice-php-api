<?php

declare(strict_types=1);

namespace Sysix\LexOffice;

use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Stream;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Utils
{
    public static function getJsonFromResponse(ResponseInterface $response): mixed
    {
        $body = $response->getBody()->__toString();

        if ($response->getHeaderLine('Content-Type') === 'application/json') {
            return self::jsonDecode($body);
        }

        return null;
    }

    /**
     * @param array{size?: int, metadata?: mixed[], mode?: bool, seekable?: bool} $options
     */
    public static function streamFor(string $resource = '', array $options = []): Stream
    {
        if (is_scalar($resource)) {
            $stream = fopen('php://temp', 'r+');
            if ($resource !== '' && $stream) {
                fwrite($stream, $resource);
                fseek($stream, 0);

                return new Stream($stream, $options);
            }
        }

        throw new InvalidArgumentException('Invalid resource type: ' . gettype($resource));
    }

    /**
     * @param int<1, max> $depth
     */
    public static function jsonEncode(mixed $value, int $options = 0, int $depth = 512): string
    {
        $json = (string) json_encode($value, $options, $depth);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('json_encode error: ' . json_last_error_msg());
        }

        return $json;
    }

    /**
     * @param int<1, max> $depth
     */
    public static function jsonDecode(string $json, bool $assoc = false, int $depth = 512, int $options = 0): mixed
    {
        $data = json_decode($json, $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }

    public static function createStream(mixed $content): StreamInterface
    {
        return Utils::streamFor(Utils::jsonEncode($content));
    }

    /**
     * @param array<string, string|bool|resource> $content
     */
    public static function createMultipartStream(array $content, string $boundary = null): MultipartStream
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
