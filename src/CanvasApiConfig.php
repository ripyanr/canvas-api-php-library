<?php

namespace Uncgits\CanvasApi;

class CanvasApiConfig
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
     * The host for the API, without protocols (e.g. mydomain.instructure.com)
     *
     * @var string
     */
    private $apiHost = null;

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
     * Fixed limit on the number of results to return from the API. 0 is unlimited.
     *
     * @var integer
     */
    private $maxResults = 0;

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $apiHost
     * @return void
     */
    public function setApiHost($apiHost)
    {
        // strip protocol if provided
        $apiHost = preg_replace("(^https?://)", "", $apiHost);
        $this->apiHost = $apiHost;
    }

    /**
     * @param string $token
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param mixed $proxyHost
     * @return void
     */
    public function setProxyHost($proxyHost)
    {
        // strip protocol if provided
        $proxyHost = preg_replace("(^https?://)", "", $proxyHost);
        $this->proxyHost = $proxyHost;
    }

    /**
     * @param string $proxyPort
     * @return void
     */
    public function setProxyPort(string $proxyPort)
    {
        $this->proxyPort = $proxyPort;
    }

    /**
     * @param boolean $useProxy
     * @return void
     */
    public function setUseProxy(bool $useProxy)
    {
        $this->useProxy = ($useProxy === true);
    }

    /**
     * @param int $maxResults
     * @return void
     */
    public function setMaxResults(int $maxResults)
    {
        $this->maxResults = $maxResults;
    }
}
