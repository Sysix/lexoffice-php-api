# Update from Version 0.x to 1.0

## Functions Removed

- `$api->setCacheInterface()`
- `$api->getCacheResponse()`
- `$api->setCacheResponse()`

For settings a Cache Interface check out [guzzle-cache-middleware](https://github.com/Kevinrob/guzzle-cache-middleware).  
And implement it with:
`$api = new \Clicksports\LexOffice\Api($apiKey, $guzzleClient);`

## Clients Method which will throw a BadMethodException

We implemented in the `0.x` Version some methods for the future of lexoffice API.  
At the moment, it doesn't look like the endpoint will be added soon. So we will remove them.

## Clients Namespace changed

In Version `0.x` all Clients had a separate folder/namespace. Now they will all use the namespace
`\Clicksports\Lexoffice\Clients`

