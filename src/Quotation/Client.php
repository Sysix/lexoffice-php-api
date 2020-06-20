<?php

namespace Clicksports\LexOffice\Quotation;

use Clicksports\LexOffice\BaseClient;
use Clicksports\LexOffice\Voucherlist\Client as VoucherlistClient;
use BadMethodCallException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Cache\InvalidArgumentException;

class Client extends BaseClient
{
    protected string $resource = 'quotations'
    ;
    /**
     * @param array $data
     * @param bool $finalized
     * @return ResponseInterface
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function create(array $data, $finalized = false)
    {
        $oldResource = $this->resource;

        $this->resource .= $finalized ? '?finalize=true' : '';
        $response = parent::create($data);
        $this->resource = $oldResource;

        return $response;
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
        $client->types = ['quotation'];

        return $client->getAll();
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
