<?php

namespace Uncgits\CanvasApi;

use Uncgits\CanvasApi\Clients\CanvasApiClientInterface;
use Uncgits\CanvasApi\Exceptions\CanvasApiClientException;
use Uncgits\CanvasApi\Exceptions\CanvasApiAdapterException;

class CanvasApi
{
    protected $client;

    public function __construct(array $setup = [])
    {
        if (isset($setup['client'])) {
            $this->setClient($setup['client']);
        }

        if (isset($setup['adapter'])) {
            $this->setAdapter($setup['adapter']);
        }

        if (isset($setup['config'])) {
            $this->setConfig($setup['config']);
        }
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

    public function using($client)
    {
    }

    public function __call($method, $arguments)
    {
        // delegate to client
        return $this->client->$method(...$arguments);
    }
}
