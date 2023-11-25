<?php


namespace Sysix\LexOffice;


use GuzzleHttp\Psr7\Stream;
use InvalidArgumentException;

class Utils
{
    /**
     * @param string $resource
     * @param array{size?: int, metadata?: mixed[], mode?: bool, seekable?: bool} $options
     * @return Stream
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
     * @param mixed $value
     * @param int $options
     * @param int<1, max> $depth
     * @return string
     */
    public static function jsonEncode($value, int $options = 0, int $depth = 512): string
    {
        $json = json_encode($value, $options, $depth);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('json_encode error: ' . json_last_error_msg());
        }

        /** @var string */
        return $json;
    }

    /**
     * @param string $json
     * @param bool $assoc
     * @param int<1, max> $depth
     * @param int $options
     * @return mixed
     */
    public static function jsonDecode(string $json, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        $data = json_decode($json, $assoc, $depth, $options);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new InvalidArgumentException('json_decode error: ' . json_last_error_msg());
        }

        return $data;
    }
}