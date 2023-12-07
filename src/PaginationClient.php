<?php declare(strict_types=1);

namespace Sysix\LexOffice;

use Psr\Http\Message\ResponseInterface;
use stdClass;

abstract class PaginationClient extends BaseClient
{
    public int $size = 100;

    protected function generatePageUrl(int $page): string
    {
        return $this->resource . '?' . $this->buildQueryParams([
            'page'=> $page
        ]);
    }

    /**
     * @param array<string, bool|int|string|null> $params
     */
    protected function buildQueryParams(array $params): string
    {
        $params['size'] = $this->size;

        return http_build_query($params);
    }

    public function getPage(int $page): ResponseInterface
    {
        return $this->api
            ->newRequest('GET', $this->generatePageUrl($page))
            ->getResponse();
    }

    /**
     * @deprecated 1.0 Not recommend anymore because of Rate Limiting, WILL be removed in 2.0
     */
    public function getAll(): ResponseInterface
    {
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_WARNING);

        $response = $this->getPage(0);
        /** @var ?stdClass{totalPages:int, content:stdClass[]} $result */
        $result = Utils::getJsonFromResponse($response);

        if ($result === null || $result->totalPages == 1) {
            return $response;
        }

        // update content to get all contacts
        for ($i = 1; $i < $result->totalPages; $i++) {
            $responsePage = $this->getPage($i);
            /** @var ?stdClass{totalPages:int, content:stdClass[]} $resultPage */
            $resultPage = Utils::getJsonFromResponse($responsePage);

            if ($resultPage === null) {
                continue;
            }

            foreach ($resultPage->content as $entity) {
                $result->content = [
                    ...$result->content,
                    $entity
                ];
            }
        }

        return $response->withBody(Utils::createStream($result));
    }
}