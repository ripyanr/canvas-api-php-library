<?php

namespace Uncgits\CanvasApi\Traits;

use Uncgits\CanvasApi\CanvasApiConfig;
use Uncgits\CanvasApi\Exceptions\CanvasApiConfigException;

trait ExecutesCanvasApiCalls
{
    /*
    |--------------------------------------------------------------------------
    | Implementation of CanvasApiAdapter interface
    |--------------------------------------------------------------------------
    */

    /**
     * The CanvasApiConfig object used to make API calls.
     *
     * @var undefined
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

    public function setConfig($config)
    {
        if (is_string($config) && class_exists($config)) {
            $config = new $config;
        }

        if (is_a($config, CanvasApiConfig::class)) {
            $this->config = $config;
            return;
        }

        throw new CanvasApiConfigException('Client class must receive CanvasApiConfig object or class name in constructor');

        $this->config = $config;
    }

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
        return $this->call($endpoint, 'get');
    }

    public function post($endpoint)
    {
        return $this->call($endpoint, 'post');
    }

    public function patch($endpoint)
    {
        return $this->call($endpoint, 'patch');
    }

    public function put($endpoint)
    {
        return $this->call($endpoint, 'put');
    }

    public function delete($endpoint)
    {
        return $this->call($endpoint, 'delete');
    }

    /*
    |--------------------------------------------------------------------------
    | Additional methods
    |--------------------------------------------------------------------------
    */

    /**
     * Fluent setter for 'as_user_id' parameter, allowing a user to attempt to perform the current operation using
     *   Act As (Masquerade) functionality, if allowed in Canvas to do so.
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
     * Fluent alias for asUserId()
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUser($user_id)
    {
        return $this->asUserId($user_id);
    }

    /**
     * Fluent setter for 'per_page' parameter
     *
     * @param int $per_page
     * @return void
     */
    public function setPerPage(int $per_page)
    {
        return $this->addParameters(['per_page' => $per_page]);
    }
}
