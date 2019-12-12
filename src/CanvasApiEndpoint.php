<?php

namespace Uncgits\CanvasApi;

class CanvasApiEndpoint
{
    /**
     * The assembled endpoint to be called
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The HTTP method to use (get, post, etc.)
     *
     * @var string
     */
    protected $method;


    /**
     * Any required properties for this endpoint, in dot notation
     *
     * @var array
     */
    protected $requiredParameters;

    /**
     * Whether to interpret the first $endpoint argument as a raw endpoint (default is to calculate it based on CanvasApiConfig)
     *
     * @var false
     */
    protected $rawEndpoint;

    public function __construct(string $endpoint, string $method, array $requiredParameters = [], bool $rawEndpoint = false)
    {
        $this->endpoint = $endpoint;
        $this->method = $method;
        $this->requiredParameters = $requiredParameters;
        $this->rawEndpoint = $rawEndpoint;
    }

    /**
     * Get the value of endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get the value of method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the value of requiredParameters
     */
    public function getRequiredParameters()
    {
        return $this->requiredParameters;
    }

    public function setFinalEndpoint(CanvasApiConfig $config)
    {
        // assemble the final request URI from host and endpoint
        if (!$this->rawEndpoint) {
            $this->endpoint = 'https://' . $config->getApiHost() . $config->getPrefix() . $this->endpoint;
        }

        return $this;
    }
}
