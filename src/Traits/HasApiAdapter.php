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
            return $this->adapter;
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

    /*
    |--------------------------------------------------------------------------
    | Delegation
    |--------------------------------------------------------------------------
    */

    /**
     * Delegate a GET request to the adapter and return the calls array
     *
     * @param mixed $endpoint
     * @return array
     */
    public function get($endpoint)
    {
        return $this->adapter->get($endpoint);
    }

    /**
     * Delegate a POST request to the adapter and return the calls array
     *
     * @param mixed $endpoint
     * @return array
     */
    public function post($endpoint)
    {
        return $this->adapter->post($endpoint);
    }

    /**
     * Delegate a PATCH request to the adapter and return the calls array
     *
     * @param mixed $endpoint
     * @return array
     */
    public function patch($endpoint)
    {
        return $this->adapter->patch($endpoint);
    }

    /**
     * Delegate a PUT request to the adapter and return the calls array
     *
     * @param mixed $endpoint
     * @return array
     */
    public function put($endpoint)
    {
        return $this->adapter->put($endpoint);
    }

    /**
     * Delegate a DELETE request to the adapter and return the calls array
     *
     * @param mixed $endpoint
     * @return array
     */
    public function delete($endpoint)
    {
        return $this->adapter->delete($endpoint);
    }

    /**
     * Delegate through to adapter but return this class instead of adapter
     *
     * @param mixed $method
     * @param mixed $arguments
     * @return self
     */
    public function __call($method, $arguments)
    {
        // delegate to adapter
        $this->adapter->$method(...$arguments);
        return $this;
    }
}
