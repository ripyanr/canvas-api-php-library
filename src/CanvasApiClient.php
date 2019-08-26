<?php

namespace Uncgits\CanvasApi;

use GuzzleHttp\Client;
use Uncgits\CanvasApi\Exceptions\CanvasApiConfigException;

abstract class CanvasApiClient
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /**
     * The CanvasApiConfig object to be used in making the API call
     *
     * @var CanvasApiConfig
     */
    protected $config = null;

    /**
     * Additional headers to send with the call. Bearer token will always be sent.
     *
     * @var array
     */
    protected $additionalHeaders = [];

    /**
     * Parameters (arguments) to include in the call. For GET requests, these will be sent in the query string.
     * For POST requests, these will be sent in the body.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The properties required to be set on the Client class in order to make a call to the API.
     *
     * @var array
     */
    protected $requiredProperties = [];

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */
    public function __construct(CanvasApiConfig $config)
    {
        $this->config = $config;
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Set $additionalHeaders
     *
     * @param  array  $additionalHeaders  Additional headers to send with the call. Bearer token will always be sent.
     * @return  self
     */
    public function setAdditionalHeaders(array $additionalHeaders)
    {
        $this->additionalHeaders = $additionalHeaders;
        return $this;
    }

    /**
     * Set $parameters
     *
     * @param  array  $parameters - refer to the API documentation for the requirements of each call
     * @return  self
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get for POST requests, these will be sent in the body.
     *
     * @return  array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /*
    |--------------------------------------------------------------------------
    | User-callable methods
    |--------------------------------------------------------------------------
    */

    /**
     * Adds a parameter to the current call stack, without completely overwriting existing parameters
     *
     * @param array $parameters
     * @return self
     */
    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }

    /**
     * Gets one single parameter, if it exists
     *
     * @param mixed $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->parameters[$key] ?? null;
    }

    /**
     * Act as another user in Canvas for the duration of the operation
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUserId($user_id)
    {
        return $this->addParameters(['as_user_id', $user_id]);
    }

    /**
     * Alias for asUserId()
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUser($user_id)
    {
        return $this->asUserId($user_id);
    }

    /*
    |--------------------------------------------------------------------------
    | API Call methods
    |--------------------------------------------------------------------------
    */

    protected function makeCall($endpoint, $method)
    {
        foreach ($this->requiredProperties as $property) {
            if ($this->$property === null || empty($this->$property)) {
                throw new CanvasApiConfigException("Error: required property '$property' has not been set in API Client class.");
            }
        }

        // assemble the final request URI from host and endpoint
        $endpoint = 'https://' . $this->config->getApiHost() . $this->config->getPrefix() . $endpoint;

        // instantiate Guzzle client
        $client = new Client;

        // params / body
        if (count($this->parameters) > 0) {
            if (strtolower($method) == 'get') {
                // this is to support include[] and similar...
                $string = http_build_query($this->parameters, null, '&');
                $string = preg_replace('/%5B\d+%5D=/', '%5B%5D=', $string);
                $requestOptions['query'] = $string;
            } else {
                $requestOptions['form_params'] = $this->parameters;
            }
        }

        // set proxy settings. set explicitly to empty string if not being used.
        $requestOptions['proxy'] = $this->config->getProxy();

        // set headers
        $requestOptions['headers'] = [
            'Authorization' => 'Bearer ' . $this->config->getToken(),
        ];
        if (count($this->additionalHeaders) > 0) {
            $requestOptions['headers'] = array_merge($requestOptions['headers'], $this->additionalHeaders);
        }

        // disable Guzzle exceptions. this class is responsible for providing an account of what happened, so we need
        // to get the response back no matter what.
        $requestOptions['http_errors'] = false;

        // perform the call
        $response = $client->$method($endpoint, $requestOptions);

        // clean up parameters unless this was called by paginate()
        // $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
        // if ($caller !== 'paginate') {
        //     $this->setParameters([]);
        // }

        // normalize the result
        return [
            'request' => [
                'endpoint'   => $endpoint,
                'method'     => $method,
                'headers'    => $requestOptions['headers'],
                'proxy'      => $this->config->getProxy(),
                'parameters' => $this->parameters,
            ],
            'response' => [
                'headers'    => $response->getHeaders(),
                'pagination' => $this->parse_http_rels($response->getHeaders()),
                'code'       => $response->getStatusCode(),
                'reason'     => $response->getReasonPhrase(),
                'body'       => json_decode($response->getBody()->getContents())
            ],
        ];
    }

    protected function call($endpoint, $method, $calls = [])
    {
        $calls[] = $result = $this->makeCall($endpoint, $method);
        if (!is_null($result['response']['pagination'])) {
            if (isset($result['response']['pagination']['next']) || $result['response']['pagination']['current'] != $result['response']['pagination']['last']) {
                $nextEndpoint = str_replace($this->config->getPrefix(), '', $result['response']['pagination']['next']);
                return $this->call($nextEndpoint, $method, $calls);
            }
        }

        // clean up parameters
        $this->setParameters([]);

        return $calls;
    }

    protected function get($endpoint)
    {
        return $this->call($endpoint, 'get');
    }

    protected function post($endpoint)
    {
        return $this->call($endpoint, 'post');
    }

    protected function patch($endpoint)
    {
        return $this->call($endpoint, 'patch');
    }

    protected function put($endpoint)
    {
        return $this->call($endpoint, 'put');
    }

    protected function delete($endpoint)
    {
        return $this->call($endpoint, 'delete');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper methods
    |--------------------------------------------------------------------------
    */

    private function parse_http_rels($allHeaders)
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
