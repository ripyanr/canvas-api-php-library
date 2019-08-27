# Canvas API PHP Library

Contact: its-laravel-devs-l@uncg.edu

# Introduction

This package is a PHP library used to interact with the [Canvas REST API](https://canvas.instructure.com/doc/api/index.html).

## Scope

This package is not (yet) as a comprehensive interface with the Canvas API - it is not written to perform every conceivable API call to Canvas. Currently, this package suits the specific needs of UNC Greensboro's Canvas integrations, and performs only the functions necessary for day-to-day operations thereof.

It is intended for internal use - if you are external to UNCG please feel free to fork this package and modify it to suit your needs.

# Installation and Quick Start

To install the package: `composer require uncgits/canvas-api-php-library`

## Use it!

Create a class in your application that extends `Uncgits\CanvasApi\CanvasApiConfig`. Then, on `__construct()`, utilize `$this->setApiHost()` and `$this->setToken()` methods to set up your API credentials. Example:

```php
<?php

namespace App\CanvasConfigs;

use Uncgits\CanvasApi\CanvasApiConfig;

class TestEnvironment extends CanvasApiConfig
{
    public function __construct()
    {
        $this->setApiHost('someplace.test.instructure.com');
        $this->setToken('super-secret-token-that-you-would-reference-from-a-non-committed-file-of-course'); // please don't commit your token...
    }
}
```

Then, instantiate the client you want, based on the type of call(s) you want to make. All of the API clients (see below) are configured to accept a `CanvasApiConfig` object or class string in the constructor.

```php
// OPTION 1 - pass instance

// get a new config object
$config = new App\CanvasConfigs\TestEnvironment();
// instantiate the client and pass in the config
$accountsClient = new \Uncgits\CanvasApi\Clients\Accounts($config);
```

```php
// OPTION 2 - pass class name
// instantiate the client and pass in the config class name
$accountsClient = new \Uncgits\CanvasApi\Clients\Accounts(App\CanvasConfigs\TestEnvironment::class);
```

Then, once you have the client, if you want to list all Accounts:

```php
// make the call
$result = $accountsClient->listAccounts(); // methods are named as they appear in Canvas API documentation
// get the contents of the result
var_dump($result->getContent()); // you receive a CanvasApiResult object
```

## Setting parameters

Some API calls need additional parameters, and there are two different ways to pass them. The way(s) you choose are directly in line with the following logic:

- If the parameter belongs in the URL, it will be required as an argument to the method call. Example: `getSingleAccount()` calls `api/v1/accounts/:id` where `:id` is the ID of the Account you want to get. Therefore, the signature for the method is `getSingleAccount($id)`, and you would pass in your account value there.

- If the parameter is not contained in the URL, you need to set it as a body parameter. This includes all required parameters as well as optional parameters. Example: `listAccounts()` does not require any parameters, but you may optionally provide an `include` parameter. Use the chainable `addParameters()` method on the client object like so:

```php
$includes = [
    'includes' => [
        'lti_guid',
        'registration_settings',
        'services'
    ],
];

$result = $accountsClient->addParameters($includes)->listAccounts();
```

Refer to the API documentation for the accepted parameters, as well as the structure of the parameters (especially for multi-level nested parameters). This library attempts to validate parameters to a point, but as of initial release cannot validate some parameters that are deeply-nested.

# Laravel wrapper

This package has a dedicated [wrapper package for Laravel](https://bitbucket.org/uncg-its/canvas-api-wrapper-laravel/src), that includes container bindings, facades, config files, and other shims to help you use this package easily within a Laravel application.

# Detailed Usage

## Architecture

### General Architecture

This library is comprised of many **Clients**, each of which interacts with one specific category / area of the Canvas API. For instance, there is a Quizzes client, an Accounts client, a Users client, and so on. Each client class is based fully on its architecture in the Canvas API Documentation. All client classes extend from the base abstract `Uncgits\CanvasApi\CanvasApiClient` class, which contains the general functionality of making an API call and parsing the result.

### Naming

Each client's methods are named as closely as possible to the names given to the operations in the API documentation. For example, the Accounts client contains `listAccounts()`, `listAccountsForCourseAdmins()`, and so on - all in line with the official documentation. The notable modification to this rule: 'a' / 'an' / 'the' are always dropped, so we have `getSingleAccount()`, `getTermsOfService()`, and so forth.

### Aliasing

Where prudent, aliasing has been employed where the Canvas API does not always adhere to logical, RESTful semantic syntax. For instance, while `getSingleAccount()` (as named via the Canvas API documentation) is descriptive, the 'single' modifier is not in line with traditional RESTful operations and could be considered superfluous; many developers would think of this as `getAccount()` instead. So, in these cases, while the original core method will always adhere to its name in the official documentation, there are many places where aliases (like this example) have been added for convenience. These aliases always call the "original" method.

## Acting as a user

If you are using this library with a token that includes the permission to "Act As" (formerly "Masquerade" as) another user, you can utilize the chainable `asUser()` method when making a call:

```php
$config = new \App\CanvasConfigs\TestEnvironment();
$userClient = new \Uncgits\CanvasApi\Clients\Users($config);

$result = $userClient->asUser(12345)->listCourseNicknames();
```

## SIS IDs

The Canvas REST API allows you to [substitute a SIS ID](https://canvas.instructure.com/doc/api/file.object_ids.html) in place of the internal Canvas ID for many items. SIS IDs are supported in this library!

Parameters passed as arguments to all methods are interpolated directly into the URL that is called. Thus, instead of calling `$userClient->getUserSettings(12345)` you could instead call `$userClient->getUserSettings('sis_login_id:jsmith')`, and it would work just fine. See the page above for where SIS IDs can and can't be substituted, and for details on how to handle encoding and escaping as needed.

## Pagination

Pagination is handled automatically, where and when necessary. Upon each API call the return headers are read, and the Link header is parsed and extracted, [in accordance with the documentation](https://canvas.instructure.com/doc/api/file.pagination.html).

To customize pagination on any API call, you may utilize `addParameters()` to set the `per_page` value to whatever you choose, or make use of the built-in helper `setPerPage()` method:

```php
$result = $accountsClient->addParameters(['per_page' => 100])->listAccounts();
// OR
$result = $accountsClient->setPerPage(100)->listAccounts();
```

Since the pagination headers are checked on every API call, each client operation may therefore initiate several API calls before it reaches completion. See below for details on how results are presented.

## Handling Results

Every time a client operation is requested, this library will encapsulate important information and present it in the `Uncgits\CanvasApi\CanvasApiResult` class. Within that class, you are able to access structured information on each API call made during that operation, as well as an aggregated resultset that should be iterable as an array. For example, if you ask for all Accounts, and it requires 5 API calls of page size 10 to retrieve them, your result contents would be a single array of all accounts; this is designed to save you time in parsing them yourself!

```php
$result = $accountsClient->listAccounts();

// get the result content - your Account objects
$accounts = $result->getContent();

// get a list of the API calls made
$apiCalls = $result->getCalls();
// get the first API call made
$firstCall = $result->getFirstCall();
// get the last API call made
$lastCall = $result->getLastCall();

// get the aggregate status code (success or failure) based on the result of all calls
$status = $result->getStatus();
// get the aggregate message (helpful if there were failures) based on the result of all calls
$status = $result->getMessage();
```

### The API call array

Each API call (retrieved from the `$calls` array on the `CanvasApiResult` object) is made up of some key information that may be useful as you deal with things like throttling (see below), or other meta information on your calls. The API call array stores information on both the request (what is sent) and the response (what is received), and is structured as follows:

```php
[
    'request' => [
        'endpoint'   => $endpoint, // the final assembled endpoint
        'method'     => $method, // get, post, put, delete
        'headers'    => $requestOptions['headers'], // all headers passed - includes bearer info
        'proxy'      => $this->config->getProxy(), // proxy host and port, if using
        'parameters' => $this->parameters, // any parameters used by the client
    ],
    'response' => [
        'headers'              => $response->getHeaders(), // raw headers
        'pagination'           => $this->parse_http_rels($response->getHeaders()), // parsed pagination information
        'code'                 => $response->getStatusCode(), // 200, 403, etc.
        'reason'               => $response->getReasonPhrase(), // OK, Forbidden, etc.
        'runtime'              => $response->getHeader('X-Runtime') ?? '', // convenience item for length of time in seconds the call ran
        'cost'                 => $response->getHeader('X-Request-Cost') ?? '', // convenience item for "cost" of call toward rate limit
        'rate-limit-remaining' => $response->getHeader('X-Rate-Limit-Remaining') ?? '', // convenience item for rate limit bucket level remaining
        'body'                 => json_decode($response->getBody()->getContents()) // raw body content of the response
    ],
]
```

### Rate limit / throttling

This library does not account for Rate Limit, Throttling, or automatic retries / exponential backoff. Most of the time, those issues are only encountered when running scripts that would invoke simultaneous API calls, and will not be a problem even when paginating through a large dataset. From Canvas API documentation:

> Since the cost of a request is roughly based on the amount of time it takes to process, and the quota (by default) replenishes at a rate faster than real-time, any API client that makes no more than one simultaneous request is unlikely to be throttled.

This library is meant to act as an interface to the Canvas REST API; therefore it does not need to be concerned about how it is being used in client applications. You should take care to handle this in your application code - if rate limits are hit, you can expect this library to tell you by way of the response information on the individual API calls (code 403 with "Rate Limit Exceeded" message).

As a convenience, rate limit information is provided in the base level array of each API call result (see above), so that you do not need to parse through headers yourself.

## Using a proxy

If you need to use an HTTP proxy, set that up in your `CanvasApiConfig` object using `setProxyHost()`, `setProxyPort()`, and `useProxy()`.

## Passing additional headers

If you need to set additional headers on your requests, you can utilize the `setAdditionalHeaders()` method on the client class, which accepts an array of key-value pairs.

# Questions? Concerns?

Please contact us at its-laravel-devs-l@uncg.edu, or open an issue on this repo (if able).

# Version History

## 0.1

- First tagged release
- Supports the following operation sets fully:
    - Account Reports
    - Accounts
    - Analytics
    - Assignments
    - Enrollments
    - EnrollmentTerms
    - Quiz Submissions
    - Quizzes
    - Roles
    - Sections
    - Tabs
- Supports the following operation sets nearly-fully (file uploads not yet included):
    - Courses
    - Users
