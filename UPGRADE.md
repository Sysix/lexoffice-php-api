# Upgrade from Version 0.x to 1.0

## Namespace Changed

All Classses with started with `\Clicksports\Lexoffice` are now under `\Sysix\Lexoffice`.

## Clients Namespace changed

In Version `0.x` all Clients had a separate folder/namespace. Now they will all use the namespace
`\Sysix\Lexoffice\Clients`

| Old Class | New Class |
| --- | --- |
| `new \Clicksports\Lexoffice\*\Client()` | `new \Sysix\Lexoffice\Clients\*()` |
| Examples  |
| `new \Clicksports\Lexoffice\Country\Client()` | `new \Sysix\Lexoffice\Clients\Country()` |
| `new \Clicksports\Lexoffice\Voucher\Client()` | `new \Sysix\Lexoffice\Clients\Voucher()` |

## Requires PHP 8.1

PHP 8.0 is now [End of Security Support](https://www.php.net/supported-versions.php) and our dev Packages already require PHP 8.1.  
So we are dumping our software to PHP 8.1. 


## ClientInterface is required

In Version `0.x` the `\Sysix\LexOffice\Api` requires only one constructor parameter (The API Key). Now a second parameter is also required.  
In the past a `GuzzleHttp\Client` was the second optional parameter. no any PSR-18 compatible HTTP-Client is allowed.  
 `GuzzleHttp\Client` was already one of it.

 If you want still use `guzzlehttp/guzzle` just update your code as following:

 ```php
 $api = new \Sysix\LexOffice\Api($apiKey, new \GuzzleHttp\Client());
 ```

## Error Responses dont throws Exceptions

To be [PSR-18 compatible](https://www.php-fig.org/psr/psr-18/) any responses with status code > 400 will not throw an Exception.
Make sure you check the status code before accessing the entities:

```php
/** @var \Sysix\LexOffice\Api $api */
$client = $api->*();
$response = $client->*();

// https://developers.lexoffice.io/docs/#http-status-codes
if ($response->getStatusCode() === 200 /* 201 | 202 | 204 */ ) {
  $json = $client()->getAsJson($response);
}
```

## Errors dont get wrapped into `\Sysix\Lexoffice\Exceptions\LexOfficeApiException`

Because we are allowing [PSR-18 Clients](https://www.php-fig.org/psr/psr-18/) we don't wrap the `GuzzleException` into an `LexOfficeApiException`.
The Only times `LexOfficeApiException` is now thrown, is when you are uploading a file. 
This can maybe change in the future!

## Cache removed

The HTTP-Client is now in charge of caching. When you are still using `guzzlehttp/guzzle`,  
you can use the following middleware: [guzzle-cache-middleware](https://github.com/Kevinrob/guzzle-cache-middleware).  
And implement it with:
`$api = new \Sysix\LexOffice\Api($apiKey, $guzzleClient);`

## Clients Methods which would throw an BadMethodException

We implemented in the `0.x` Version some methods for the future of lexoffice API.  
At the moment, it doesn't look like the endpoint will be added soon. So we will remove them.

## Functions Removed

- `$api->setCacheInterface()`
- `$api->getCacheResponse()`
- `$api->setCacheResponse()`

## Exceptions Removed

- `\Sysix\Lexoffice\Exception\CacheException`
- `\Sysix\Lexoffice\Exception\BadMethodException`


## Functions Deprecated

This functions will be removed in the next major (2.0) Update

- `\Sysix\Lexoffice\Clients\CreditNote::getAll`
- `\Sysix\Lexoffice\Clients\DownPaymentInvoice::getAll`
- `\Sysix\Lexoffice\Clients\Invoice::getAll`
- `\Sysix\Lexoffice\Clients\OrderConfirmation::getAll`
- `\Sysix\Lexoffice\Clients\Quotation::getAll`
- `\Sysix\Lexoffice\Clients\Voucher::getAll`
- `\Sysix\Lexoffice\Clients\VoucherList::setToEverything`
- 
- `\Sysix\Lexoffice\Clients\CreditNote::getPage`
- `\Sysix\Lexoffice\Clients\DownPaymentInvoice::getPage`
- `\Sysix\Lexoffice\Clients\Invoice::getPage`
- `\Sysix\Lexoffice\Clients\OrderConfirmation::getPage`
- `\Sysix\Lexoffice\Clients\Quotation::getPage`
- `\Sysix\Lexoffice\Clients\Voucher::getPage`

For almost all clients there is a new method called `getVoucherListClient` which returns a `\Sysix\LexOffice\Api\Clients\VoucherList`.  
With this client there are more filters for the vouchers.

! You need to set a non-empty `statuses` property to the `\Sysix\LexOffice\Api\Clients\VoucherList`


## Strict Typed

Every Method has now strict Parameters and strict Return Types. If you extended some classes, you probably need to update them too.