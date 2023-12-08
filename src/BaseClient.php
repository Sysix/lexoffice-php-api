<?php declare(strict_types=1);


namespace Sysix\LexOffice;

use Psr\Http\Message\ResponseInterface;

abstract class BaseClient implements ClientInterface
{
    protected string $resource;

    public function __construct(
        protected Api $api
        )
    {
    }

    /**
     * @deprecated 1.0 use Sysix\LexOffice\Utils::getJsonFromResponse()
     */
    public function getAsJson(ResponseInterface $response): object
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, use \Sysix\LexOffice\Utils::getJsonFromResponse instead', E_USER_DEPRECATED);

        $body = $response->getBody()->__toString();

        return Utils::jsonDecode($body);
    }
}
