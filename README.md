# Lexoffice PHP API

![tests](https://github.com/sysix/lexoffice-php-api/workflows/tests/badge.svg)
![test coverage](https://raw.githubusercontent.com/sysix/lexoffice-php-api/badges/.badges/development/coverage.svg)
[![type coverage](https://shepherd.dev/github/Sysix/lexoffice-php-api/coverage.svg)](https://shepherd.dev/github/Sysix/lexoffice-php-api)
[![Latest Stable Version](https://poser.pugx.org/sysix/lex-office-api/v)](//packagist.org/packages/sysix/lex-office-api)
[![License](https://poser.pugx.org/sysix/lex-office-api/license)](//packagist.org/packages/sysix/lex-office-api)

## Requirements

PHP: >= 8.1
Extensions:
- [Composer](https://getcomposer.org/)
- [PHP-JSON](https://www.php.net/manual/en/book.json.php)
- [PSR-18 HTTP-Client](https://packagist.org/providers/psr/http-client-implementation)

## Install

composer:
`composer require sysix/lex-office-api`

## Usage

Search for the [official API Documentation](https://developers.lexoffice.io/docs/).
You need an [API Key](https://app.lexoffice.de/addons/public-api) for that.

### Basic
```php
// store keys in .env file
$apiKey = getenv('LEXOFFICE_API_KEY');

// in this example we are using guzzlehttp/guzzle package, it can be any PSR-18 HTTP Client
// see: https://packagist.org/providers/psr/http-client-implementation
$httpClient = \GuzzleHttp\Client();
$api = new \Sysix\LexOffice\Api($apiKey, $httpClient);
```

### Optimize your HTTP Client

This library only prepares the `\Psr\Http\Message\RequestInterface` for the HTTP Client and returns its Response.
There are almost no error checks, no caching and no rate limiting. Your PSR-18 HTTP Client should come with a way to deal with it.

Here is a example with `guzzlehttp/guzzle` , `kevinrob/guzzle-cache-middleware` and `spatie/guzzle-rate-limiter-middleware`:

```php
$apiKey = getenv('LEXOFFICE_API_KEY');

$stack = \GuzzleHttp\HandlerStack::create();
$stack->push(new \Kevinrob\GuzzleCache\CacheMiddleware(), 'cache');
$stack->push(\Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware::perSecond(2));

$httpClient = \GuzzleHttp\Client(['handler' => $stack]);
$api = new \Sysix\LexOffice\Api($apiKey, $httpClient);
```

## Endpoints


### Article Endpoint
```php

/** @var \Sysix\LexOffice\Api $api */
$client = $api->article();

// filters
$client->size = 100;
$client->sortDirection = 'DESC';

$client->articleNumber = 'LXW-BUHA-2024-001';
$client->gtin = '9783648170632';
$client->type = 'PRODUCT';


// get a page
$response = $client->getPage(0);

// other methods
$response = $client->get($entityId);
$response = $client->create($data);
$response = $client->update($entityId, $data);
$response = $client->delete($entityId);

```

### Contact Endpoint
```php

$client = $api->contact();

// filters
$client->size = 100;
$client->email = 'john.doe@example.com';
$client->name = 'John Doe';
$client->number = 123456;
$client->customer = true;
$client->vendor = false;

// get a page
$response = $client->getPage(0);

// other methods
$response = $client->get($entityId);
$response = $client->create($data);
$response = $client->update($entityId, $data);

```

### Country Endpoint
```php
$response = $api->country()->getAll();
```

### Credit Notes Endpoint
```php
$voucherList = $api->creditNote()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->creditNote()->get($entityId);
$response = $api->creditNote()->create($data);
$response = $api->creditNote()->create($data, true); // finalized
$response = $api->creditNote()->pursue($precedingSalesVoucherId, $data);
$response = $api->creditNote()->pursue($precedingSalesVoucherId, $data, true); // finalized
$response = $api->creditNote()->file($entityId); // get file content
$response = $api->creditNote()->file($entityId, 'application/xml'); // as XRechnung

// deprecated methods:
$response = $api->creditNote()->document($entityId); // get document ID
$response = $api->creditNote()->document($entityId, true); // get file content
$response = $api->creditNote()->document($entityId, true, 'application/xml'); // as XRechnung
```

### Deliverys Notes Endpoint
```php
$voucherList = $api->deliveryNote()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->deliveryNote()->get($entityId);
$response = $api->deliveryNote()->create($data);
$response = $api->deliveryNote()->pursue($precedingSalesVoucherId, $data);
$response = $api->deliveryNote()->file($entityId); // get file content

// deprecated methods:
$response = $api->deliveryNote()->document($entityId); // get document ID
$response = $api->deliveryNote()->document($entityId, true); // get file content
```

### Down Payment Invoices Endpoint
```php
$voucherList = $api->downPaymentInvoice()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->downPaymentInvoice()->get($entityId);
$response = $api->downPaymentInvoice()->create($data);
$response = $api->downPaymentInvoice()->file($entityId); // get file content
$response = $api->downPaymentInvoice()->file($entityId, 'application/xml'); // as XRechnung

// deprecated methods:
$response = $api->downPaymentInvoice()->document($entityId); // get document ID
$response = $api->downPaymentInvoice()->document($entityId, true); // get file content
$response = $api->downPaymentInvoice()->document($entityId, true, 'application/xml'); // as XRechnung
```

### Dunnings Endpoint
```php
$response = $api->dunning()->get($entityId);
$response = $api->dunning()->pursue($precedingSalesVoucherId, $data);
$response = $api->dunning()->file($entityId); // get file content

// deprecated methods:
$response = $api->dunning()->document($entityId); // get document ID
$response = $api->dunning()->document($entityId, true); // get file content
```

### Event Subscriptions Endpooint
```php
$response = $api->event()->get($entityId);
$response = $api->event()->create($data);
$response = $api->event()->delete($entityId);
$response = $api->event()->getAll();
```

### File Endpoint
```php
$response = $api->file()->upload($filePath, $voucherType);
$response = $api->file()->get($entityId); // accept every file
$response = $api->file()->get($entityId, 'image/*'); // accept only images
$response = $api->file()->get($entityId, 'application/xml'); // get XRechung XML File (if possible)
```

### Invoices Endpoint
```php
$voucherList = $api->invoice()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->invoice()->get($entityId);
$response = $api->invoice()->create($data);
$response = $api->invoice()->create($data, true); // finalized
$response = $api->invoice()->pursue($precedingSalesVoucherId, $data);
$response = $api->invoice()->pursue($precedingSalesVoucherId, $data, true); // finalized
$response = $api->invoice()->file($entityId); // get file content
$response = $api->invoice()->file($entityId, 'application/xml'); // as XRechnung

// deprecated methods:
$response = $api->invoice()->document($entityId); // get document ID
$response = $api->invoice()->document($entityId, true); // get file content
$response = $api->invoice()->document($entityId, true, 'application/xml'); // as XRechung XML File
```

### Order Confirmation Endpoint
```php
$voucherList = $api->orderConfirmation()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->orderConfirmation()->get($entityId);
$response = $api->orderConfirmation()->create($data);
$response = $api->orderConfirmation()->pursue($precedingSalesVoucherId, $data);
$response = $api->orderConfirmation()->file($entityId); // get file content

// deprecated methods:
$response = $api->orderConfirmation()->document($entityId); // get document ID
$response = $api->orderConfirmation()->document($entityId, true); // get file content
```

### Payment  Endpoint
```php
$response = $api->payment()->get($entityId);
```

### Payment Conditions Endpoint
```php
$response = $api->paymentCondition()->getAll();
```

### Posting Categories Endpoint
```php
$response = $api->postingCategory()->getAll();
```

### Print Layouts Endpoint
```php
$response = $api->printLayout()->getAll();
```

### Profile Endpoint
```php
$response = $api->profile()->get();
```

### Quotation Endpoint
```php
$voucherList = $api->quotation()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->quotation()->get($entityId);
$response = $api->quotation()->create($data);
$response = $api->quotation()->create($data, true); // finalized
$response = $api->quotation()->file($entityId); // get file content

// deprecated methods:
$response = $api->quotation()->document($entityId); // get document ID
$response = $api->quotation()->document($entityId, true); // get file content
```

### Recurring Templates Endpoint
```php

$client = $api->recurringTemplate();

// filters
$client->size = 100;
$client->sortDirection = 'DESC';
$client->sortColumn = 'updatedDate';

// get a page
$response = $client->getPage(0);

// other methods
$response = $api->recurringTemplate()->get($entityId);
```

### Voucher Endpoint
```php
$response = $api->voucher()->get($entityId);
$response = $api->voucher()->create($data);
$response = $api->voucher()->update($entityId, $data);
$response = $api->voucher()->upload($entitiyId, $filepath);
```

### Voucherlist Endpoint
```php
$client = $api->voucherlist();

$client->size = 100;
$client->sortDirection = 'DESC';
$client->sortColumn = 'voucherNumber';

// filters required
$client->types = [
    'salesinvoice',
    'salescreditnote',
    'purchaseinvoice',
    'purchasecreditnote',
    'invoice',
    'downpaymentinvoice',
    'creditnote',
    'orderconfirmation',
    'quotation'
];
$client->statuses = [
    'draft',
    'open',
    'paid',
    'paidoff',
    'voided',
    //'overdue', overdue can only be fetched alone
    'accepted',
    'rejected'
];

// filters optional
$client->archived = true;
$client->contactId = 'some-uuid-string';
$client->voucherDateFrom = new \DateTime('2023-12-01');
$client->voucherDateTo = new \DateTime('2023-12-01');
$client->createdDateFrom = new \DateTime('2023-12-01');;
$client->createdDateTo = new \DateTime('2023-12-01');
$client->updatedDateFrom = new \DateTime('2023-12-01');
$client->updatedDateTo = new \DateTime('2023-12-01');

// get a page
$response = $client->getPage(0);
```

## Utils

### get JSON from Success and Error Response

```php
// can be possible null because the response body can be empty
$json = \Sysix\LexOffice\Utils::getJsonFromResponse($response); // as object
$json = \Sysix\LexOffice\Utils::getJsonFromResponse($response, true); // as associative array
```
