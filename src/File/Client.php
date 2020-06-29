<?php

namespace Clicksports\LexOffice\File;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Exceptions\BadMethodCallException;
use Clicksports\LexOffice\Exceptions\CacheException;
use Clicksports\LexOffice\Exceptions\LexOfficeApiException;
use Psr\Http\Message\ResponseInterface;

class Client extends BaseClient
{
    const MAX_FILE_SIZE = 5 * 1024 * 1024;

    protected string $resource = 'files';

    protected array $supportedExtension = ['png', 'jpg', 'pdf'];

    /**
     * @param string $filepath
     * @param string $type
     * @return ResponseInterface
     * @throws LexOfficeApiException
     * @throws CacheException
     */
    public function upload(string $filepath, string $type)
    {
        $regex = '/.(' . implode('|', $this->supportedExtension) . ')/';
        $matchResult = preg_match($regex, $filepath, $matches);

        if (!$matchResult || !$matches[0]) {
            throw new LexOfficeApiException('file extension is not supported: ' . basename($filepath) . ' ');
        }

        if (!is_file($filepath)) {
            throw new LexOfficeApiException('file could not be found to upload: ' . $filepath);
        }

        if (filesize($filepath) > self::MAX_FILE_SIZE) {
            throw new LexOfficeApiException('file is to big to upload: ' . $filepath . ', max upload size: ' . self::MAX_FILE_SIZE . 'bytes');
        }

        $api = $this->api->newRequest('POST', $this->resource, [
            'Content-Type' => 'multipart/form-data'
        ]);

        $api->request = $api->request->withBody($this->createMultipartStream([
            'file' => fopen($filepath, 'r'),
            'type' => $type
        ]));

        return $api->getResponse();
    }

    /**
     * @param array $data
     * @throws BadMethodCallException
     */
    public function create(array $data)
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }

    /**
     * @throws BadMethodCallException
     */
    public function getAll()
    {
        throw new BadMethodCallException('method update is defined for ' . $this->resource);
    }
}
