<?php

namespace Uncgits\CanvasApi\Adapters;

use GuzzleHttp\Client;
use Uncgits\CanvasApi\CanvasApiConfig;
use Uncgits\CanvasApi\CanvasApiEndpoint;
use Uncgits\CanvasApi\Traits\ExecutesCanvasApiCalls;

class Guzzle implements CanvasApiAdapterInterface
{
    use ExecutesCanvasApiCalls;

    /*
    |--------------------------------------------------------------------------
    | Implementing CanvasApiAdapterInterface
    |--------------------------------------------------------------------------
    */

    public function call($endpoint, $method)
    {
        // instantiate Guzzle client
        $client = new Client;

        // params / body
        if (count($this->parameters) > 0) {
            if (strtolower($method) == 'get' || $this->urlEncodeParameters) {
                // this is to support include[] and similar...
                $string = http_build_query($this->parameters, null, '&');
                $string = preg_replace('/%5B\d+%5D=/', '%5B%5D=', $string);
                $requestOptions['query'] = $string;

                // GET requests that need pagination will pass params back in the query string of pagination headers.
                $this->setParameters([]);
            } else {
                $requestOptions['json'] = $this->parameters;
            }
        }

        // set proxy settings. set explicitly to empty string if not being used.
        $requestOptions['proxy'] = $this->config->getProxy();

        // set headers
        if ($this->withAuthorizationHeader) {
            $requestOptions['headers'] = [
                'Authorization' => 'Bearer ' . $this->config->getToken(),
            ];
        }

        // multipart
        if (count($this->multipart) > 0) {
            // Guzzle sets our Content-Type header for us
            $requestOptions['multipart'] = $this->multipart;
        }

        if (count($this->additionalHeaders) > 0) {
            $requestOptions['headers'] = array_merge($requestOptions['headers'], $this->additionalHeaders);
        }

        // disable Guzzle exceptions. this class is responsible for providing an account of what happened, so we need
        // to get the response back no matter what.
        $requestOptions['http_errors'] = false;
        // perform the call
        $response = $client->$method($endpoint, $requestOptions);

        // normalize the result
        return $this->normalizeResult($endpoint, $method, $requestOptions, $response);
    }

    public function usingConfig(CanvasApiConfig $config)
    {
        $this->config = $config;
        return $this;
    }

    public function transaction(CanvasApiEndpoint $endpoint, $calls = [])
    {
        // set up
        $this->validateParameters($endpoint);

        // make the call(s)
        $calls[] = $result = $this->call($endpoint->getEndpoint(), $endpoint->getMethod());
        if (!is_null($result['response']['pagination'])) {
            if (isset($result['response']['pagination']['next']) || $result['response']['pagination']['current'] != $result['response']['pagination']['last']) {
                $nextEndpoint = new CanvasApiEndpoint(
                    str_replace($this->config->getPrefix(), '', $result['response']['pagination']['next']),
                    $endpoint->getMethod(),
                    $endpoint->getRequiredParameters()
                );

                return $this->transaction($nextEndpoint->setFinalEndpoint($this->config), $calls);
            }
        }

        // clean up
        $this->setParameters([]);
        $this->setMultipart([]);
        $this->setRequiredParameters([]);
        $this->urlEncodeParameters = false;
        $this->withAuthorizationHeader = true;

        return $calls;
    }

    /**
     * Normalizes and formats API call information into an array for convenience
     *
     * @param string $endpoint
     * @param string $method
     * @param array $requestOptions
     * @param GuzzleHttp\Psr7\Response $response
     * @return void
     */
    public function normalizeResult($endpoint, $method, $requestOptions, $response)
    {
        return [
            'request' => [
                'endpoint'   => $endpoint,
                'query'      => $requestOptions['query'] ?? '',
                'method'     => $method,
                'headers'    => $requestOptions['headers'],
                'proxy'      => $this->config->getProxy(),
                'parameters' => $this->parameters,
                'multipart'  => $this->multipart,
            ],
            'response' => [
                'headers'              => $response->getHeaders(),
                'pagination'           => $this->parsePagination($response->getHeaders()),
                'code'                 => $response->getStatusCode(),
                'reason'               => $response->getReasonPhrase(),
                'runtime'              => $response->getHeader('X-Runtime') ?? '',
                'cost'                 => $response->getHeader('X-Request-Cost') ?? '',
                'rate-limit-remaining' => $response->getHeader('X-Rate-Limit-Remaining') ?? '',
                'body'                 => json_decode($response->getBody()->getContents())
            ],
        ];
    }

    public function parsePagination($allHeaders)
    {
        if (!isset($allHeaders['Link'][0])) {
            return null;
        }

        $responseHeaders = explode(",", $allHeaders['Link'][0]);

        $replaceValuesArray = [
            '<',
            '>; ',
            'rel="current"',
            'rel="first"',
            'rel="prev"',
            'rel="last"',
            'rel="next"',
            'https://' . $this->config->getApiHost(),
        ];

        $paginationHeaders = [];

        foreach ($responseHeaders as $header) {
            if (strstr($header, 'rel="current"')) {
                $paginationHeaders['current'] = str_replace($replaceValuesArray, '', $header);
            } elseif (strstr($header, 'rel="first"')) {
                $paginationHeaders['first'] = str_replace($replaceValuesArray, '', $header);
            } elseif (strstr($header, 'rel="prev"')) {
                $paginationHeaders['prev'] = str_replace($replaceValuesArray, '', $header);
            } elseif (strstr($header, 'rel="next"')) {
                $paginationHeaders['next'] = str_replace($replaceValuesArray, '', $header);
            } elseif (strstr($header, 'rel="last"')) {
                $paginationHeaders['last'] = str_replace($replaceValuesArray, '', $header);
            }
        }

        return $paginationHeaders;
    }
}
