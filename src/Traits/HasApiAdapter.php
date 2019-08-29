<?php

namespace Uncgits\CanvasApi\Traits;

use Uncgits\CanvasApi\Adapters\CanvasApiAdapterInterface;
use Uncgits\CanvasApi\Exceptions\CanvasApiAdapterException;

trait HasApiAdapter
{
    /*
    |--------------------------------------------------------------------------
    | Implementation of CanvasApiClientInterface
    |--------------------------------------------------------------------------
    */

    protected $adapter;

    public function setAdapter($adapter)
    {
        if (is_string($adapter) && class_exists($adapter)) {
            $adapter = new $adapter;
        }

        if ($adapter instanceof CanvasApiAdapterInterface) {
            $this->adapter = $adapter;
            return;
        }

        throw new CanvasApiAdapterException('Unknown or invalid Canvas API Adapter.');
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    /*
    |--------------------------------------------------------------------------
    | Other methods
    |--------------------------------------------------------------------------
    */

    public function __call($method, $arguments)
    {
        // delegate to adapter
        return $this->adapter->$method(...$arguments);
    }
}
