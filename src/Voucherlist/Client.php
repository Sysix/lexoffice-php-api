<?php

namespace Clicksports\LexOffice\Voucherlist;

use Clicksports\LexOffice\BaseClient;
use BadMethodCallException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Cache\InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\stream_for;

class Client extends BaseClient
{
    public string $sortColumn = 'voucherNumber';
    public string $sortDirection = 'DESC';

    public array $types = [];

    public array $statuses = [];

    public function setToEverything()
    {
        $this->types = [
            'salesinvoice',
            'salescreditnote',
            'purchaseinvoice',
            'purchasecreditnote',
            'invoice',
            'creditnote',
            'orderconfirmation',
            'quotation'
        ];

        $this->statuses = [
            'draft',
            'open',
            'paid',
            'paidoff',
            'voided',
            //'overdue',
            'accepted',
            'rejected'
        ];
    }

    /**
     * @param int $page
     * @return string
     */
    protected function generateUrl(int $page): string
    {
        return 'voucherlist?page=' . $page .
            '&size=100' .
            '&sort=' . $this->sortColumn . ',' . $this->sortDirection .
            '&voucherType=' . implode(',', $this->types) .
            '&voucherStatus=' . implode(',', $this->statuses);
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getAll()
    {
        $api = $this->api->newRequest(
            'GET',
            $this->generateUrl(0)
        );

        $response = $api->getResponse();
        $result = $this->getAsJson($response);

        if ($result->totalPages == 1) {
            return $response;
        }

        $result->content = [];

        // update content to get all contacts
        for ($i = 1; $i < $result->totalPages; $i++) {
            $api = $this->api->newRequest(
                'GET',
                $this->generateUrl($i)
            );

            $responsePage = $api->getResponse();
            $resultPage = $this->getAsJson($responsePage);

            foreach ($resultPage->content as $contact) {
                $result->content[] = $contact;
            }
        }

        return $response->withBody(stream_for(json_encode($result)));
    }

    /**
     * @param array $data
     * @throws BadMethodCallException
     */
    public function create(array $data)
    {
        throw new BadMethodCallException('method create is not defined for voucherlist');
    }

    /**
     * @param string $id
     * @param array $data
     * @throws BadMethodCallException
     */
    public function update(string $id, array $data)
    {
        throw new BadMethodCallException('method update is not defined for voucherlist');
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function get(string $id)
    {
        throw new BadMethodCallException('method get is not defined for voucherlist');
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function delete(string $id)
    {
        throw new BadMethodCallException('method delete is not defined for voucherlist');
    }
}
