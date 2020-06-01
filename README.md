# Lexoffice PHP API

## Install

// TODO: setup composer package

composer:  
`composer require clicksports/lex-office-api`

## Usage

You need an [API Key](https://app.lexoffice.de/settings/#/public-api) for that.

### Basic
```php
$apiKey = getenv('LEX_OFFICE_API_KEY'); // store keys in .env file
$api = new \Clicksports\LexOffice\Api($apiKey);
```

### Contact Endpoint
```php
$api = new \Clicksports\LexOffice\Api($apiKey);
$api->contact()->getAll();
$api->contact()->get($contactId);
$api->contact()->create($data);
$api->contact()->update($contactId, $data);
$api->contact()->delete($contactId);
```

### Invoices Endpoint
```php
$api = new \Clicksports\LexOffice\Api($apiKey);
$api->invoice()->getAll();
$api->invoice()->get($invoiceId);
$api->invoice()->create($data);
$api->invoice()->update($invoiceId, $data);
$api->invoice()->delete($invoiceId);
```


### Order Confirmation Endpoint
```php
$api = new \Clicksports\LexOffice\Api($apiKey);
$api->orderConfirmation()->getAll();
$api->orderConfirmation()->get($entityId);
$api->orderConfirmation()->create($data);
$api->orderConfirmation()->update($entityId, $data);
$api->orderConfirmation()->delete($entityId);
```

### Quotation Endpoint
```php
$api = new \Clicksports\LexOffice\Api($apiKey);
$api->quotation()->getAll();
$api->quotation()->get($entityId);
$api->quotation()->create($data);
$api->quotation()->update($entityId, $data);
$api->quotation()->delete($entityId);
```

### Voucher Endpoint
```php
$api = new \Clicksports\LexOffice\Api($apiKey);
$api->voucher()->getAll();
$api->voucher()->get($entityId);
$api->voucher()->create($data);
$api->voucher()->update($entityId, $data);
$api->voucher()->delete($entityId);
```

### Voucherlist Endpoint
```php
$api = new \Clicksports\LexOffice\Api($apiKey);
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
$client->getPage(0);

//get all
$client->getAll();
```

