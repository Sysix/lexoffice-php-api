<?php

declare(strict_types=1);

namespace Sysix\LexOffice\Clients\Traits;

use Psr\Http\Message\ResponseInterface;

/**
 * @deprecated use the FileClientTrait instead
 */
trait DocumentClientTrait
{
    use FileClientTrait;

    public function document(string $id, bool $asContent = false, string $acceptHeader = '*/*'): ResponseInterface
    {
        trigger_error(__METHOD__.' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

        if ($asContent === false) {
            $response = $this->api
                ->newRequest('GET', $this->resource . '/' . rawurlencode($id) . '/document')
                ->getResponse();

            return $response;
        }

        return $this->file($id, $acceptHeader);
    }
}
