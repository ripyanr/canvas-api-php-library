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
}
