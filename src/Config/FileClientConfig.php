<?php declare(strict_types=1);

namespace Sysix\LexOffice\Config;

use Sysix\LexOffice\Config\FileClient\VoucherConfig;

class FileClientConfig
{
    public static function getVoucherConfig(): VoucherConfig
    {
        return new VoucherConfig();
    }
}