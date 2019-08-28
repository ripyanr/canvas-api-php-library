<?php

namespace Uncgits\CanvasApi;

use Uncgits\CanvasApi\Adapters\CanvasApiAdapter;

abstract class CanvasApiClient
{
    protected $adapter;

    public function __construct($config, CanvasApiAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->adapter->setConfig($config);
    }

    public function __call($method, $arguments)
    {
        // delegate to adapter
        return $this->adapter->$method(...$arguments);
    }
}
