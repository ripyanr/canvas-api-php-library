<?php

namespace Uncgits\CanvasApi;

use Uncgits\CanvasApi\Clients\CanvasApiClientInterface;
use Uncgits\CanvasApi\Exceptions\CanvasApiClientException;
use Uncgits\CanvasApi\Exceptions\CanvasApiAdapterException;

class CanvasApi
{
    protected $client;
    protected $adapter;
    protected $config;

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
        if (empty($this->client)) {
            throw new CanvasApiClientException('Must set Client before setting Adapter.');
        }

        $this->client->setAdapter($adapter);
        return $this;
    }

    public function setConfig($config)
    {
        if (empty($this->client)) {
            throw new CanvasApiClientException('Must set Client and Adapter before setting Config.');
        }

        if (empty($this->client->getAdapter())) {
            throw new CanvasApiAdapterException('Must set Adapter before setting Config.');
        }

        $this->client->getAdapter()->setConfig($config);

        return $this;
    }

    public function setup()
    {
        if (!is_null($this->client)) {
            $this->setClient($this->client);

            if (!is_null($this->adapter)) {
                $this->setAdapter($this->adapter);

                if (!is_null($this->config)) {
                    $this->setConfig($this->config);
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
            throw new \Exception('Class ' . $client . ' not found');
        }

        $this->client = new $client;

        return $this->setup();
    }

    public function __call($method, $arguments)
    {
        // delegate to client
        return $this->client->$method(...$arguments);
    }
}
