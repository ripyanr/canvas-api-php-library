<?php

namespace Uncgits\CanvasApi;

use GuzzleHttp\Client;
use Uncgits\CanvasApi\Exceptions\CanvasApiConfigException;
use Uncgits\CanvasApi\Exceptions\CanvasApiParameterException;

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
     *   For POST requests, these will be sent in the body.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The parameters required by the Canvas API. If these parameters are not set before making the call, a
     *   CanvasApiParameterException will be thrown.
     *
     * @var array
     */
    protected $requiredParameters = [];

    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */
    public function __construct($config)
    {
        if (is_string($config) && class_exists($config)) {
            $config = new $config;
        }

        if (is_a($config, CanvasApiConfig::class)) {
            $this->config = $config;
            return;
        }

        throw new CanvasApiConfigException('Client class must receive CanvasApiConfig object or class name in constructor');
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

    /**
     * Set $requiredParameters
     *
     * @param  array  $requiredParameters - refer to the API documentation for the requirements of each call
     * @return  self
     */
    public function setRequiredParameters(array $requiredParameters)
    {
        $this->requiredParameters = $requiredParameters;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get current parameter set
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
        $this->addParameters(['as_user_id' => $user_id]);
        return $this;
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

    /**
     * Shortcut method for setting the 'per_page' parameter
     *
     * @param int $per_page
     * @return self
     */
    public function setPerPage(int $per_page)
    {
        return $this->addParameters(['per_page' => $per_page]);
    }

    /*
    |--------------------------------------------------------------------------
    | API Call methods
    |--------------------------------------------------------------------------
    */

    protected function makeCall($endpoint, $method)
    {
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
                $requestOptions['json'] = $this->parameters;
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

        // normalize the result
        return $this->normalizeResult($endpoint, $method, $requestOptions, $response);
    }

    protected function call($endpoint, $method, $calls = [])
    {
        // set up
        $this->validateParameters();

        // make the call(s)
        $calls[] = $result = $this->makeCall($endpoint, $method);
        if (!is_null($result['response']['pagination'])) {
            if (isset($result['response']['pagination']['next']) || $result['response']['pagination']['current'] != $result['response']['pagination']['last']) {
                $nextEndpoint = str_replace($this->config->getPrefix(), '', $result['response']['pagination']['next']);
                return $this->call($nextEndpoint, $method, $calls);
            }
        }

        // clean up
        $this->setParameters([]);
        $this->setRequiredParameters([]);

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

    /**
     * Normalizes and formats API call information into an array for convenience
     *
     * @param string $endpoint
     * @param string $method
     * @param array $requestOptions
     * @param GuzzleHttp\Psr7\Response $response
     * @return void
     */
    protected function normalizeResult($endpoint, $method, $requestOptions, $response)
    {
        return [
            'request' => [
                'endpoint'   => $endpoint,
                'method'     => $method,
                'headers'    => $requestOptions['headers'],
                'proxy'      => $this->config->getProxy(),
                'parameters' => $this->parameters,
            ],
            'response' => [
                'headers'              => $response->getHeaders(),
                'pagination'           => $this->parse_http_rels($response->getHeaders()),
                'code'                 => $response->getStatusCode(),
                'reason'               => $response->getReasonPhrase(),
                'runtime'              => $response->getHeader('X-Runtime') ?? '',
                'cost'                 => $response->getHeader('X-Request-Cost') ?? '',
                'rate-limit-remaining' => $response->getHeader('X-Rate-Limit-Remaining') ?? '',
                'body'                 => json_decode($response->getBody()->getContents())
            ],
        ];
    }

    /**
     * Flatten a multi-dimensional associative array with dots. From Illuminate\Support\Arr
     *
     * @param  array   $array
     * @param  string  $prepend
     * @return array
     */

    protected function dot($array, $prepend = '')
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge($results, $this->dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }
        return $results;
    }

    protected function validateParameters()
    {
        // flatten out params array to dot notation for easy checking
        $parametersDotted = $this->dot($this->parameters);

        $missingRequiredParameters = array_diff($this->requiredParameters, array_keys($parametersDotted));

        $missingRequiredParametersBracketed = [];
        if (!empty($missingRequiredParameters)) {
            foreach ($missingRequiredParameters as $parameter) {
                $segments = explode('.', $parameter);
                $bracketedName = $segments[0];

                for ($i = 1; $i < count($segments); $i++) {
                    if (isset($segments[$i])) {
                        $bracketedName .= "[{$segments[$i]}]";
                    }
                }
                $missingRequiredParametersBracketed[] = $bracketedName;
            }

            throw new CanvasApiParameterException('Missing required parameter(s) \'' . implode(',', $missingRequiredParametersBracketed) . '\'');
        }
    }

    protected function parse_http_rels($allHeaders)
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
