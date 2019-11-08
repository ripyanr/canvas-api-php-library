<?php

namespace Uncgits\CanvasApi\Traits;

use Uncgits\CanvasApi\CanvasApiConfig;
use Uncgits\CanvasApi\CanvasApiEndpoint;
use Uncgits\CanvasApi\Exceptions\CanvasApiParameterException;

trait ExecutesCanvasApiCalls
{
    /*
    |--------------------------------------------------------------------------
    | Implementation of CanvasApiAdapterInterface
    |--------------------------------------------------------------------------
    */

    /**
     * The CanvasApiConfig object used to make API calls.
     *
     * @var CanvasApiConfig
     */
    protected $config;

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

    /**
     * Multipart data to be sent with the call (e.g. for file uploads)
     *
     * @var array
     */
    protected $multipart = [];

    public function setAdditionalHeaders(array $additionalHeaders)
    {
        $this->additionalHeaders = $additionalHeaders;
        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function setRequiredParameters(array $requiredParameters)
    {
        $this->requiredParameters = $requiredParameters;
        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function addParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
        return $this;
    }

    public function getParameter($key)
    {
        return $this->parameters[$key] ?? null;
    }

    public function get($endpoint)
    {
        $this->checkConfig();
        return $this->transaction($endpoint, 'get');
    }

    public function post($endpoint)
    {
        $this->checkConfig();
        return $this->transaction($endpoint, 'post');
    }

    public function patch($endpoint)
    {
        $this->checkConfig();
        return $this->transaction($endpoint, 'patch');
    }

    public function put($endpoint)
    {
        $this->checkConfig();
        return $this->transaction($endpoint, 'put');
    }

    public function delete($endpoint)
    {
        $this->checkConfig();
        return $this->transaction($endpoint, 'delete');
    }

    public function validateParameters(CanvasApiEndpoint $endpoint)
    {
        // flatten out params array to dot notation for easy checking
        $missingRequiredParameters = array_diff($endpoint->getRequiredParameters(), array_keys($this->dot($this->parameters)));

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

            throw new CanvasApiParameterException('Missing required parameter(s) \''
                . implode(',', $missingRequiredParametersBracketed) . '\'');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Additional methods
    |--------------------------------------------------------------------------
    */

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
}
