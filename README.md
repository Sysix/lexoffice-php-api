# Lexoffice PHP API

![tests](https://github.com/clicksports/lexoffice-php-api/workflows/tests/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/clicksports/lex-office-api/v)](//packagist.org/packages/clicksports/lex-office-api)
[![License](https://poser.pugx.org/clicksports/lex-office-api/license)](//packagist.org/packages/clicksports/lex-office-api)

## Requirements

PHP: >= 7.4  
Extensions: [Composer](https://getcomposer.org/), [PHP-JSON](https://www.php.net/manual/en/book.json.php)

## Install

composer:  
`composer require clicksports/lex-office-api`

## Usage

Search for the official API Documentation [here](https://developers.lexoffice.io/docs/).  
You need an [API Key](https://app.lexoffice.de/settings/#/public-api) for that.

### Basic
```php
$apiKey = getenv('LEX_OFFICE_API_KEY'); // store keys in .env file
$api = new \Clicksports\LexOffice\Api($apiKey);
```

### set cache

```php
// can be any PSR-6 compatibly cache handler
// in this example we are using symfony/cache
$cacheInterface = new \Symfony\Component\Cache\Adapter\FilesystemAdapter(
  'lexoffice',
  3600,
 __DIR__ . '/cache'
);

$api->setCacheInterface($cacheInterface);
```

### Contact Endpoint
```php

// get a page
/** @var \Clicksports\LexOffice\Api $api */
$client = $api->contact();

$client->size = 100;
$client->sortDirection = 'ASC';
$client->sortProperty = 'name';

// get a page
$response = $client->getPage(0);    

//get all
$response = $client->getAll();

// other methods
$response = $client->get($entityId);
$response = $client->create($data);
$response = $client->update($entityId, $data);
```

### Invoices Endpoint
```php
$response = $api->invoice()->getAll();
$response = $api->invoice()->get($entityId);
$response = $api->invoice()->create($data);
```


### Order Confirmation Endpoint
```php
$response = $api->orderConfirmation()->getAll();
$response = $api->orderConfirmation()->get($entityId);
$response = $api->orderConfirmation()->create($data);
$response = $api->quotation()->document($entityId); // get document ID
$response = $api->quotation()->document($entityId, true); // get file content
```

### Quotation Endpoint
```php
$response = $api->quotation()->getAll();
$response = $api->quotation()->get($entityId);
$response = $api->quotation()->create($data);
$response = $api->quotation()->document($entityId); // get document ID
$response = $api->quotation()->document($entityId, true); // get file content
```

### Voucher Endpoint
```php
$response = $api->voucher()->getAll();
$response = $api->voucher()->get($entityId);
$response = $api->voucher()->create($data);
$response = $api->voucher()->update($entityId, $data);
$response = $api->quotation()->document($entityId); // get document ID
$response = $api->quotation()->document($entityId, true); // get file content
```


### Credit Notes Endpoint
```php
$response = $api->creditNote()->getAll();
$response = $api->creditNote()->get($entityId);
$response = $api->creditNote()->create($data);
$response = $api->quotation()->document($entityId); // get document ID
$response = $api->quotation()->document($entityId, true); // get file content
```

### Profile Endpoint
```php
$response = $api->profile()->get();
```

### Voucherlist Endpoint
```php
$client = $api->voucherlist();

$client->size = 100;
$client->sortDirection = 'DESC';
$client->sortColumn = 'voucherNumber';
$client->types = [
    'salesinvoice',
    'salescreditnote',
    'purchaseinvoice',
    'purchasecreditnote',
    'invoice',
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

// get everything what we can, not recommend:
//$client->setToEverything()

// get a page
$response = $client->getPage(0);

//get all
$response = $client->getAll();
```

### File Endpoint
```php
$response = $api->file()->upload($filePath, $voucherType);
$response = $api->file()->get($entityId);
```


### get JSON from Response

```php
$json = $api->voucher()->getAsJson($response);
```