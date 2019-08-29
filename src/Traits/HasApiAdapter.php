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

    /**
     * Fluent setter for 'as_user_id' parameter, allowing a user to attempt to perform the current operation using
     *   Act As (Masquerade) functionality, if allowed in Canvas to do so.
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUserId($user_id)
    {
        $this->adapter->addParameters(['as_user_id' => $user_id]);
        return $this;
    }

    /**
     * Fluent alias for asUserId()
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUser($user_id)
    {
        $this->asUserId($user_id);
        return $this;
    }

    /**
     * Fluent setter for 'per_page' parameter
     *
     * @param int $per_page
     * @return void
     */
    public function setPerPage(int $per_page)
    {
        return $this->addParameters(['per_page' => $per_page]);
    }

    public function __call($method, $arguments)
    {
        // delegate to adapter
        return $this->adapter->$method(...$arguments);
    }
}
