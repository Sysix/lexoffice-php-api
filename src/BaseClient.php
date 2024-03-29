<?php

declare(strict_types=1);

namespace Sysix\LexOffice;

use Psr\Http\Message\ResponseInterface;
use Sysix\LexOffice\Interfaces\ApiInterface;
use Sysix\LexOffice\Interfaces\ClientInterface;

abstract class BaseClient implements ClientInterface
{
    protected string $resource;

    public function __construct(
        protected ApiInterface $api
    ) {
    }

    /**
     * @deprecated 1.0 use Sysix\LexOffice\Utils::getJsonFromResponse()
     *
     * @codeCoverageIgnore
     */
    public function getAsJson(ResponseInterface $response): mixed
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, use \Sysix\LexOffice\Utils::getJsonFromResponse instead', E_USER_DEPRECATED);

        $body = $response->getBody()->__toString();

        return Utils::jsonDecode($body);
    }
}
