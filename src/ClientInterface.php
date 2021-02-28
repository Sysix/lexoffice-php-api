<?php declare(strict_types=1);

namespace Clicksports\LexOffice;

interface ClientInterface
{
    /**
     * ClientInterface constructor.
     * @param Api $lexOffice
     */
    public function __construct(Api $lexOffice);
}
