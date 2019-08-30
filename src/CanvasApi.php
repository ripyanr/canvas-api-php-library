<?php

namespace Uncgits\CanvasApi;

use Uncgits\CanvasApi\Clients\CanvasApiClientInterface;
use Uncgits\CanvasApi\Exceptions\CanvasApiClientException;

class CanvasApi
{
    protected $client;
    protected $adapter;
    protected $config;

    protected $tempClient;

    public function __construct(array $setup = [])
    {
        $this->client = $setup['client'] ?? null;
        $this->adapter = $setup['adapter'] ?? null;
        $this->config = $setup['config'] ?? null;
        $this->setup();
    }

    public function setClient($client)
    {
        if (is_string($client) && class_exists($client)) {
            $client = new $client;
        }

        if ($client instanceof CanvasApiClientInterface) {
            $this->client = $client;
            return $this;
        }

        throw new CanvasApiClientException('Unknown or invalid Canvas API Client class.');
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function setup()
    {
        if (!is_null($this->client)) {
            $this->setClient($this->client);

            if (!is_null($this->adapter)) {
                $this->client->setAdapter($this->adapter);

                if (!is_null($this->config)) {
                    $this->client->getAdapter()->setConfig($this->config);
                }
            }
        }

        return $this;
    }

    public function using($client)
    {
        // assume default client location in package unless we were given something that looks namespaced
        if (strpos($client, '\\') === false) {
            $client = '\\Uncgits\\CanvasApi\\Clients\\' . str_replace(' ', '', ucwords($client));
        }

        if (!class_exists($client)) {
            throw new \Exception('Client class ' . $client . ' not found');
        }

        $this->tempClient = new $client;
        return $this;
    }

    public function __call($method, $arguments)
    {
        // delegate to client

        if (!is_null($this->tempClient)) {
            $this->tempClient->setAdapter($this->adapter)->setConfig($this->config);
            $result = $this->tempClient->$method(...$arguments);
            $this->tempClient = null;
            return $result;
        }

        if (!is_null($this->client)) {
            return $this->client->$method(...$arguments);
        }

        throw new CanvasApiClientException('Client is not set on API class');
    }
}
