<?php

declare (strict_types=1);

namespace Sysix\LexOffice\Config\FileClient;

use Sysix\LexOffice\Exceptions\LexOfficeApiException;

class VoucherConfig
{
    public const MAX_FILE_SIZE = 5 * 1024 * 1024;

    /** @var string[] */
    protected array $supportedExtension = ['png', 'jpg', 'pdf'];

    public function validateFileFromFilePath(string $filepath): void
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
    }
}
