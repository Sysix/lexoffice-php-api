<?php declare(strict_types=1);

namespace Sysix\LexOffice;

interface ClientInterface
{
    public function __construct(Api $lexOffice);
}
