<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Interfaces;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ApiInterface
{
    /**
     * @param string[] $headers
     */
    public function newRequest(string $method, string $resource, array $headers = []): self;

    public function setRequest(RequestInterface $request): self;

    public function getRequest(): RequestInterface;

    public function getResponse(): ResponseInterface;
}
