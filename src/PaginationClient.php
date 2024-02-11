<?php

declare(strict_types=1);

namespace Sysix\LexOffice;

use Psr\Http\Message\ResponseInterface;

abstract class PaginationClient extends BaseClient
{
    public int $size = 100;

    public string $sortColumn;

    public string $sortDirection = 'DESC';

    protected function generatePageUrl(int $page): string
    {
        return $this->resource . '?' . $this->buildQueryParams([
            'page' => $page
        ]);
    }

    /**
     * @param array<string, bool|int|string|null> $params
     */
    protected function buildQueryParams(array $params): string
    {
        $params['size'] = $this->size;

        // contact endpoint can't be sorted but is a Pagination client
        if (isset($this->sortColumn)) {
            $params['sort'] = $this->sortColumn . ',' . $this->sortDirection;
        }

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
        trigger_error(self::class . '::' . __METHOD__ . ' should not be called anymore, in future versions this method WILL not exist', E_USER_DEPRECATED);

        $response = $this->getPage(0);
        $result = Utils::getJsonFromResponse($response);

        if (
            $result === null || !is_object($result) ||
            !property_exists($result, 'totalPages') || $result->totalPages == 1 ||
            !property_exists($result, 'content')
        ) {
            return $response;
        }

        // update content to get all contacts
        for ($i = 1; $i < $result->totalPages; $i++) {
            $responsePage = $this->getPage($i);

            if ($responsePage->getStatusCode() !== 200) {
                return $responsePage;
            }

            $resultPage = Utils::getJsonFromResponse($responsePage);

            if (
                $resultPage === null ||
                !is_object($resultPage) ||
                !property_exists($resultPage, 'content') ||
                !is_array($resultPage->content) ||
                !is_array($result->content)
            ) {
                return $responsePage;
            }

            array_push($result->content, ...$resultPage->content);
        }

        return $response->withBody(Utils::createStream($result));
    }
}
