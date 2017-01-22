# Signature

**A PHP 5.4+ port of the [Signature](https://github.com/mloughran/signature) ruby gem**

[![Build Status](https://travis-ci.org/philipbrown/signature-php.png?branch=master)](https://travis-ci.org/philipbrown/signature-php)
[![Code Coverage](https://scrutinizer-ci.com/g/philipbrown/signature-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/philipbrown/signature-php/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/philipbrown/signature-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/philipbrown/signature-php/?branch=master)

## Installation
Add `tartan/laravel-hmac-signature` as a requirement to `composer.json`:
```bash
$ composer require iamtartan/laravel-hmac-signature
```

## What is HMAC-SHA authentication?
HMAC-SHA authentication allows you to implement very simple key / secret authentication for your API using hashed signatures.

## Making a request
```php
use Tartan\Signature\Token;
use Tartan\Signature\Request;

$data    = [
    'first_name' => 'Aboozar', 
    'last_name'  => 'Ghaffari',
    'email'      => 'iamtartan@gmail.com' 
];
$token   = new Token('my_public_key', 'my_private_key');
$request = new Request('POST', 'signup', $data);

$auth = $request->sign($token);

$finalData = array_merge($auth, $data);

$yourHttpClient->post('signup', $finalData);

```

## Authenticating a response
```php
use Tartan\Signature\Auth;
use Tartan\Signature\Token;
use Tartan\Signature\Guards\CheckKey;
use Tartan\Signature\Guards\CheckVersion;
use Tartan\Signature\Guards\CheckTimestamp;
use Tartan\Signature\Guards\CheckSignature;
use Tartan\Signature\Exceptions\SignatureException;

$auth  = new Auth($request->method(), $request->url(), $request->all(), [
	new CheckKey,
	new CheckVersion,
	new CheckTimestamp,
	new CheckSignature
]);

$token   = new Token('my_public_key', 'my_private_key');

try {
    $auth->attempt($token);
}

catch (SignatureException $e) {
    // return 401
}

catch (Exception $e) {
    // return 400;
}
```

## Changing the default HTTP request prefix
By default, this package uses `auth_*` in requests. You can change this behaviour when signing and and authenticating requests:
```php
// default, the HTTP request uses auth_version, auth_key, auth_timestamp and auth_signature
$request->sign($token);
// the HTTP request now uses x-version, x-key, x-timestamp and x-signature
$request->sign($token, 'x-');
```

If you changed the default, you will need to authenticate the request accordingly:
```php
$auth->attempt($token, 'x-');
```
