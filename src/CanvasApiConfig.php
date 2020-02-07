<?php

namespace Uncgits\CanvasApi;

abstract class CanvasApiConfig
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    |
    | Environment, Authentication, and Configuration information for the client.
    | Set these values in a script or a wrapper for whatever framework you're
    | using.
    |
    */

    /**
     * The host domain for the API, without protocols (e.g. mydomain.instructure.com)
     *
     * @var string
     */
    private $apiHost = null;

    /**
     * The API prefix (default is for V1 of the Canvas REST API)
     *
     * @var string
     */
    private $prefix = '/api/v1/';

    /**
     * The API token to be used in calling the API
     *
     * @var string
     */
    private $token = null;

    /**
     * The host for the HTTP proxy to be used
     *
     * @var string
     */
    private $proxyHost = null;

    /**
     * The port for the HTTP proxy to be used
     *
     * @var string
     */
    private $proxyPort = null;

    /**
     * Whether to use the HTTP proxy when calling the API
     *
     * @var boolean
     */
    private $useProxy = false;

    /**
     * Fixed limit on the number of results to return from the API. Default is 9999, but should be overridden where appropriate.
     *
     * @var integer
     */
    private $maxResults = 9999;

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $apiHost
     * @return self
     */
    public function setApiHost($apiHost)
    {
        // strip protocol if provided
        $this->apiHost = preg_replace("(^https?://)", "", $apiHost);
        return $this;
    }
    /**
     * @param  string  $prefix
     * @return  self
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @param string $token
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param mixed $proxyHost
     * @return self
     */
    public function setProxyHost($proxyHost)
    {
        // strip protocol if provided
        $this->proxyHost = preg_replace("(^https?://)", "", $proxyHost);
        return $this;
    }

    /**
     * @param string $proxyPort
     * @return self
     */
    public function setProxyPort(string $proxyPort)
    {
        $this->proxyPort = $proxyPort;
        return $this;
    }

    /**
     * @param boolean $useProxy
     * @return self
     */
    public function setUseProxy(bool $useProxy)
    {
        $this->useProxy = ($useProxy === true);
        return $this;
    }

    /**
     * @param int $maxResults
     * @return self
     */
    public function setMaxResults(int $maxResults)
    {
        $this->maxResults = $maxResults;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * Get the host domain for the API, without protocols (e.g. mydomain.instructure.com)
     *
     * @return  string
     */
    public function getApiHost()
    {
        return $this->apiHost;
    }

    /**
     * Get the API prefix (default is for V1 of the Canvas REST API)
     *
     * @return  string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the API token to be used in calling the API
     *
     * @return  string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the host for the HTTP proxy to be used
     *
     * @return  string
     */
    public function getProxyHost()
    {
        return $this->proxyHost;
    }

    /**
     * Get whether to use the HTTP proxy when calling the API
     *
     * @return  boolean
     */
    public function getUseProxy()
    {
        return $this->useProxy;
    }

    /**
     * Shortcut to get the formatted proxy string
     *
     * @return  string
     */
    public function getProxy()
    {
        return $this->useProxy ?
            $this->proxyHost . ':' . $this->proxyPort :
            '';
    }

    /**
     * Get fixed limit on the number of results to return from the API. 0 is unlimited.
     *
     * @return  integer
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }
}
