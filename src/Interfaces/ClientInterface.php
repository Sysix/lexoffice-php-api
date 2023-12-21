<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Interfaces;

interface ClientInterface
{
    public function __construct(ApiInterface $lexOffice);
}
