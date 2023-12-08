# Lexoffice PHP API

![tests](https://github.com/sysix/lexoffice-php-api/workflows/tests/badge.svg)
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
$apiKey = getenv('LEX_OFFICE_API_KEY'); 

// in this example we are using guzzlehttp/guzzle package, it can be any PSR-18 HTTP Client 
// see: https://packagist.org/providers/psr/http-client-implementation
$httpClient = \GuzzleHttp\Client();
$api = new \Sysix\LexOffice\Api($apiKey, $httpClient);
```

#### Optimize your HTTP Client

This library only prepares the `\Psr\Http\Message\RequestInterface` for the HTTP Client and returns its Response.  
There are almost no error checks, no caching and no rate limiting. Your PSR-18 HTTP Client should come with a way to deal with it.  

Here is a example with `guzzlehttp/guzzle` , `kevinrob/guzzle-cache-middleware` and `spatie/guzzle-rate-limiter-middleware`:

```php
$apiKey = getenv('LEX_OFFICE_API_KEY'); 

$stack = \GuzzleHttp\HandlerStack();
$stack->push(new \Kevinrob\GuzzleCache\CacheMiddleware\CacheMiddleware(), 'cache');
$stack->push(\Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware\RateLimiterMiddleware::perSecond(2));

$httpClient = \GuzzleHttp\Client(['handler' => $stack]);
$api = new \Sysix\LexOffice\Api($apiKey, $httpClient);

```

### Contact Endpoint
```php

/** @var \Sysix\LexOffice\Api $api */
$client = $api->contact();

// filters
$client->size = 100;
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

### Invoices Endpoint
```php
$voucherList = $api->invoice()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->invoice()->get($entityId);
$response = $api->invoice()->create($data);
$response = $api->invoice()->document($entityId); // get document ID
$response = $api->invoice()->document($entityId, true); // get file content
```

### Down Payment Invoices Endpoint
```php
$voucherList = $api->downPaymentInvoice()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->downPaymentInvoice()->get($entityId);
$response = $api->downPaymentInvoice()->create($data);
$response = $api->downPaymentInvoice()->document($entityId); // get document ID
$response = $api->downPaymentInvoice()->document($entityId, true); // get file content
```

### Order Confirmation Endpoint
```php
$voucherList = $api->orderConfirmation()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->orderConfirmation()->get($entityId);
$response = $api->orderConfirmation()->create($data);
$response = $api->orderConfirmation()->document($entityId); // get document ID
$response = $api->orderConfirmation()->document($entityId, true); // get file content
```

### Quotation Endpoint
```php
$voucherList = $api->quotation()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->quotation()->get($entityId);
$response = $api->quotation()->create($data);
$response = $api->quotation()->document($entityId); // get document ID
$response = $api->quotation()->document($entityId, true); // get file content
```

### Voucher Endpoint
```php
$response = $api->voucher()->get($entityId);
$response = $api->voucher()->create($data);
$response = $api->voucher()->update($entityId, $data);
$response = $api->voucher()->document($entityId); // get document ID
$response = $api->voucher()->document($entityId, true); // get file content
$response = $api->voucher()->upload($entitiyId, $filepath);
```


### Credit Notes Endpoint
```php
$voucherList = $api->creditNote()->getVoucherListClient(); // see VoucherlistClient Documentation
$response = $api->creditNote()->get($entityId);
$response = $api->creditNote()->create($data);
$response = $api->creditNote()->document($entityId); // get document ID
$response = $api->creditNote()->document($entityId, true); // get file content
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

### Profile Endpoint
```php
$response = $api->profile()->get();
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

### File Endpoint
```php
$response = $api->file()->upload($filePath, $voucherType);
$response = $api->file()->get($entityId);
```


### get JSON from Success and Error Response

```php
// can be possible null because the response body can be empty
$json = \Sysix\LexOffice\Utils::getJsonFromResponse($response);
```