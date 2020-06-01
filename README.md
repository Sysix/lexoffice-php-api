# Lexoffice PHP API

## Install

composer:  
`composer require clicksports/lex-office-api`

## Usage

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
$cacheInterface = new \Symfony\Component\Cache\Adapter\FilesystemAdapter([
  'lexoffice',
  3600,
 __DIR__ . '/cache'
]);

$api->setCacheInterface($cacheInterface);
```

### Contact Endpoint
```php
$response = $api->contact()->getAll();
$response = $api->contact()->get($contactId);
$response = $api->contact()->create($data);
$response = $api->contact()->update($contactId, $data);
```

### Invoices Endpoint
```php
$response = $api->invoice()->getAll();
$response = $api->invoice()->get($invoiceId);
$response = $api->invoice()->create($data);
```


### Order Confirmation Endpoint
```php
$response = $api->orderConfirmation()->getAll();
$response = $api->orderConfirmation()->get($entityId);
$response = $api->orderConfirmation()->create($data);
```

### Quotation Endpoint
```php
$response = $api->quotation()->getAll();
$response = $api->quotation()->get($entityId);
$response = $api->quotation()->create($data);
```

### Voucher Endpoint
```php
$response = $api->voucher()->getAll();
$response = $api->voucher()->get($entityId);
$response = $api->voucher()->create($data);
$response = $api->voucher()->update($entityId, $data);
```

### Voucherlist Endpoint
```php
$client = $api->voucherlist();
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

### get JSON from Response

```php
$json = $api->voucher()->getAsJson($response);
```