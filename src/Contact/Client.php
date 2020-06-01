<?php

namespace Clicksports\LexOffice\Contact;

use Clicksports\LexOffice\BaseClient;
use BadMethodCallException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;
use function GuzzleHttp\Psr7\stream_for;

class Client extends BaseClient
{
    /**
     * @param array $data
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function create(array $data)
    {
        $api = $this->api->newRequest('POST', 'contacts');

        $api->request = $api->request->withBody(stream_for(
            json_encode($data)
        ));

        return $api->getResponse();
    }

    /**
     * @param string $id
     * @param array $data
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws GuzzleException
     */
    public function update(string $id, array $data)
    {
        $api = $this->api->newRequest('PUT', 'contacts/' . $id);

        $api->request = $api->request->withBody(stream_for(
            http_build_query($data)
        ));

        return $api->getResponse();
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getAll()
    {
        $api = $this->api->newRequest('GET', 'contacts?page=0&size=100&direction=ASC&property=name');

        $response = $api->getResponse();
        $result = $this->getAsJson($response);

        if ($result->totalPages == 1) {
            return $response;
        }

        $result->content = [];

        // update content to get all contacts
        for ($i = 1; $i < $result->totalPages; $i++) {
            $api = $this->api->newRequest('GET', 'contacts?page=' . $i . '&size=100&direction=ASC&property=name');

            $responsePage = $api->getResponse();
            $resultPage = $this->getAsJson($responsePage);

            foreach ($resultPage->content as $contact) {
                $result->content[] = $contact;
            }
        }

        return $response->withBody(stream_for(json_encode($result)));
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws GuzzleException
     */
    public function get(string $id)
    {
        return $this->api->newRequest('GET', 'contacts/' . $id)
            ->getResponse();
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function delete(string $id)
    {
        throw new BadMethodCallException('method delete is defined for contacts');
    }
}
