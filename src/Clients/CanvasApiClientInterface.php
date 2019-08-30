<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\Adapters\CanvasApiAdapterInterface;

interface CanvasApiClientInterface
{
    /**
     * Sets the adapter (implements CanvasApiAdapterInterface) used to make the call
     *
     * @param CanvasApiAdapterInterface|string $adapter
     * @return CanvasApiAdapterInterface
     */
    public function setAdapter($adapter);

    /**
     * Gets the name of the currently-set adapter
     *
     * @return string
     */
    public function getAdapter();

    /**
     * Act as another user in Canvas for the duration of the operation
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUserId($user_id);

    /**
     * Alias for asUserId()
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUser($user_id);

    /**
     * Shortcut method for setting the 'per_page' parameter
     *
     * @param int $per_page
     * @return self
     */
    public function setPerPage(int $per_page);

    /**
     * Delegate a GET request to the adapter and return the result
     *
     * @param mixed $endpoint
     * @return array
     */
    public function get($endpoint);

    /**
     * Delegate a POST request to the adapter and return the result
     *
     * @param mixed $endpoint
     * @return array
     */
    public function post($endpoint);

    /**
     * Delegate a PATCH request to the adapter and return the result
     *
     * @param mixed $endpoint
     * @return array
     */
    public function patch($endpoint);

    /**
     * Delegate a PUT request to the adapter and return the result
     *
     * @param mixed $endpoint
     * @return array
     */
    public function put($endpoint);

    /**
     * Delegate a DELETE request to the adapter and return the result
     *
     * @param mixed $endpoint
     * @return array
     */
    public function delete($endpoint);

    /**
     * checks to ensure a valid adapter has been set before attempting to delegate
     *
     * @throws CanvasApiAdapterException
     * @return void
     */
    public function checkAdapter();
}
