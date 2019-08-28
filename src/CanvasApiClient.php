<?php

namespace Uncgits\CanvasApi;

use Uncgits\CanvasApi\Adapters\CanvasApiAdapter;
use Uncgits\CanvasApi\Exceptions\CanvasApiAdapterException;

abstract class CanvasApiClient
{
    protected $adapter;

    public function __construct($config, $adapter)
    {
        $this->setAdapter($adapter);
        $this->adapter->setConfig($config);
    }

    public function setAdapter($adapter)
    {
        if (is_string($adapter) && class_exists($adapter)) {
            $adapter = new $adapter;
        }

        if (is_a($adapter, CanvasApiAdapter::class)) {
            $this->adapter = $adapter;
            return;
        }

        throw new CanvasApiAdapterException('Client class must receive CanvasApiAdapter object or class name in constructor');
    }

    public function __call($method, $arguments)
    {
        // delegate to adapter
        return $this->adapter->$method(...$arguments);
    }
}
