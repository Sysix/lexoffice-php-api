<?php

namespace Clicksports\LexOffice;

use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\stream_for;

abstract class PaginationClient extends BaseClient
{
    public int $size = 100;

    /**
     * @param int $page
     * @return string
     */
    protected function generateUrl(int $page): string
    {
        return $this->resource . '?page=' . $page . '&size=' . $this->size;
    }

    /**
     * @param int $page
     * @return ResponseInterface
     * @throws Exceptions\CacheException
     * @throws Exceptions\LexOfficeApiException
     */
    public function getPage(int $page): ResponseInterface
    {
        $api = $this->api->newRequest(
            'GET',
            $this->generateUrl($page)
        );

        return $api->getResponse();
    }

    /**
     * @return ResponseInterface
     * @throws Exceptions\CacheException
     * @throws Exceptions\LexOfficeApiException
     */
    public function getAll()
    {
        $response = $this->getPage(0);
        $result = $this->getAsJson($response);

        if ($result->totalPages == 1) {
            return $response;
        }

        // update content to get all contacts
        for ($i = 1; $i < $result->totalPages; $i++) {
            $responsePage = $this->getPage($i);
            $resultPage = $this->getAsJson($responsePage);

            foreach ($resultPage->content as $entity) {
                $result->content = [
                    ...$result->content,
                    $entity
                ];
            }
        }

        return $response->withBody(stream_for(json_encode($result)));
    }
}