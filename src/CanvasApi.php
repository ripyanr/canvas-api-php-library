<?php

namespace Uncgits\CanvasApi;

use Uncgits\CanvasApi\Adapters\CanvasApiAdapter;
use Uncgits\CanvasApi\Exceptions\CanvasApiAdapterException;

class CanvasApi
{
    protected $adapter;
    protected $config;
    protected $client;

    public function __construct(array $setup = [])
    {
        if (isset($setup['adapter'])) {
            $this->setAdapter($setup['adapter']);
        }

        if (isset($setup['config'])) {
            $this->setConfig($setup['config']);
        }

        if (isset($setup['client'])) {
            $this->setClient($setup['client']);
        }
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

        throw new CanvasApiAdapterException('CanvasApi must receive CanvasApiAdapter object or class name in constructor');
    }

    public function setConfig($config)
    {
        if (is_string($config) && class_exists($config)) {
            $config = new $config;
        }

        if (is_a($config, CanvasApiConfig::class)) {
            $this->config = $config;
            return;
        }

        throw new CanvasApiConfigException('CanvasApi must receive CanvasApiConfig object or class name in constructor');
    }

    public function setClient($client)
    {
        if (is_string($client) && class_exists($client)) {
            $client = new $client;
        }

        if (is_a($client, CanvasApiClientInterface::class)) {
            $this->client = $client;
            return;
        }

        throw new CanvasApiClientException('CanvasApi must receive CanvasApiClient object or class name in constructor');
    }

    public function __call($method, $arguments)
    {
        // delegate to adapter
        return $this->adapter->$method(...$arguments);
    }
}
