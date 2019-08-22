<?php

namespace Uncgits\CanvasApi;

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
     * The properties required to be set on the Client class in order to make a call to the API.
     *
     * @var array
     */
    protected $requiredProperties = ['apiHost', 'token'];

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function __construct(CanvasApiConfig $config)
    {
        $this->config = $config;
    }
}
