# Update from Version 0.x to 1.0

## Namespace Changed

All Classses with started with `\Clicksports\Lexoffice` are now under `\Sysix\Lexoffice`.

## Clients Namespace changed

In Version `0.x` all Clients had a separate folder/namespace. Now they will all use the namespace
`\Sysix\Lexoffice\Clients`

| Old Class | New Class |
| --- | --- |
| `new \Clicksports\Lexoffice\Country\Client()` | `new \Sysix\Lexoffice\Clients\Country()` |
| `new \Clicksports\Lexoffice\Voucher\Client()` | `new \Sysix\Lexoffice\Clients\Voucher()` |
| ... | ... |

## Cache removed

For settings a Cache Interface check out [guzzle-cache-middleware](https://github.com/Kevinrob/guzzle-cache-middleware).  
And implement it with:
`$api = new \Sysix\LexOffice\Api($apiKey, $guzzleClient);`

## Clients Method which will throw a BadMethodException

We implemented in the `0.x` Version some methods for the future of lexoffice API.  
At the moment, it doesn't look like the endpoint will be added soon. So we will remove them.

## Functions Removed

- `$api->setCacheInterface()`
- `$api->getCacheResponse()`
- `$api->setCacheResponse()`

## Exceptions Removed

- `\Sysix\Lexoffice\Exception\CacheException`
- `\Sysix\Lexoffice\Exception\BadMethodException`

## Strict Typed

Every Method is has now strict Parameters and strict Return Types. If you extend some classes, you probably need to update them too.