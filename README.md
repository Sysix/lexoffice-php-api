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

### Country Endpoint
```php
$response = $api->country()->getAll();
```

### Invoices Endpoint
```php
$response = $api->invoice()->getAll();
$response = $api->invoice()->getAll(array $states);
$response = $api->invoice()->getPage(0);
$response = $api->invoice()->getPage(0, array $states);
$response = $api->invoice()->get($entityId);
$response = $api->invoice()->create($data);
$response = $api->invoice()->document($entityId); // get document ID
$response = $api->invoice()->document($entityId, true); // get file content
```

### Down Payment Invoices Endpoint
```php
$response = $api->downPaymentInvoice()->getAll();
$response = $api->downPaymentInvoice()->getAll(array $states);
$response = $api->downPaymentInvoice()->getPage(0);
$response = $api->downPaymentInvoice()->getPage(0, array $states);$response = $api->downPaymentInvoice()->get($entityId);
$response = $api->downPaymentInvoice()->create($data);
$response = $api->downPaymentInvoice()->document($entityId); // get document ID
$response = $api->downPaymentInvoice()->document($entityId, true); // get file content
```

### Order Confirmation Endpoint
```php
$response = $api->orderConfirmation()->getAll();
$response = $api->orderConfirmation()->getAll(array $states);
$response = $api->orderConfirmation()->getPage(0);
$response = $api->orderConfirmation()->getPage(0, array $states);
$response = $api->orderConfirmation()->get($entityId);
$response = $api->orderConfirmation()->create($data);
$response = $api->orderConfirmation()->document($entityId); // get document ID
$response = $api->orderConfirmation()->document($entityId, true); // get file content
```

### Quotation Endpoint
```php
$response = $api->quotation()->getAll();
$response = $api->quotation()->getAll(array $states);
$response = $api->quotation()->getPage(0);
$response = $api->quotation()->getPage(0, array $states);
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
$response = $api->voucher()->document($entityId); // get document ID
$response = $api->voucher()->document($entityId, true); // get file content
```


### Credit Notes Endpoint
```php
$response = $api->creditNote()->getAll();
$response = $api->creditNote()->getAll(array $states);
$response = $api->creditNote()->getPage(0);
$response = $api->creditNote()->getPage(0, array $states);
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

// get single entitiy
$response = $api->recurringTemplate()->get($entityId);

// use pagination
$client = $api->recurringTemplate();
$client->size = 100;


// get a page
$response = $client->getPage(0);

//get all
$response = $client->getAll();
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
$json = $api->*()->getAsJson($response);
```