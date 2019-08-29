<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\Adapters\CanvasApiAdapterInterface;

interface CanvasApiClientInterface
{
    /**
     * Sets the adapter (implements CanvasApiAdapterInterface) used to make the call
     *
     * @param CanvasApiAdapterInterface|string $adapter
     * @return self
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
}
