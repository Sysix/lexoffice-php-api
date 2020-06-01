<?php

namespace Clicksports\LexOffice\OrderConfirmation;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
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
        $api = $this->api->newRequest('POST', 'order-confirmations');

        $api->request = $api->request->withBody(stream_for(
            json_encode($data)
        ));

        return $api->getResponse();
    }

    /**
     * @param string $id
     * @param array $data
     * @return void
     * @throws Exception
     */
    public function update(string $id, array $data)
    {
       throw new BadMethodCallException('method update() is not implemented yet');
    }


    /**
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getAll()
    {
        $client = new VoucherlistClient($this->api);

        $client->setToEverything();
        $client->types = ['orderconfirmation'];

        return $client->getAll();
    }

    /**
     * @param string $id
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function get(string $id)
    {
        return $this->api->newRequest('GET', 'order-confirmations/' . $id)
            ->getResponse();
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     */
    public function delete(string $id)
    {
        throw new BadMethodCallException('method delete() is not implemented yet');
    }

    /**
     * @param string $id
     * @throws BadMethodCallException
     * @noinspection PhpUnusedParameterInspection
     */
    public function document(string $id)
    {
        throw new BadMethodCallException('method document() is not implemented yet');
    }
}
