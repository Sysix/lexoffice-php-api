<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

/**
 * @deprecated use the FileClientTrait or FileClientWithAcceptHeaderTrait instead
 */
trait DocumentClientTrait
{
    public function document(string $id, bool $asContent = false, string $acceptHeader = '*/*'): ResponseInterface
    {
        trigger_error(__METHOD__.' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

        if ($asContent === false) {
            $response = $this->api
                ->newRequest('GET', $this->resource . '/' . rawurlencode($id) . '/document')
                ->getResponse();

            return $response;
        }

        $this->api->newRequest('GET', $this->resource . '/' . rawurlencode($id) . '/file');

        return $this->api
            ->setRequest($this->api->getRequest()->withHeader('Accept', $acceptHeader))
            ->getResponse();
    }
}
