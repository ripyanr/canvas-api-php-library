<?php

namespace Uncgits\CanvasApi\Traits;

trait SetsCallParameters
{
    /**
     * Fluent setter for 'as_user_id' parameter, allowing a user to attempt to perform the current operation using
     *   Act As (Masquerade) functionality, if allowed in Canvas to do so.
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUserId($user_id)
    {
        return $this->addParameters(['as_user_id' => $user_id]);
    }

    /**
     * Fluent alias for asUserId()
     *
     * @param mixed $user_id
     * @return self
     */
    public function asUser($user_id)
    {
        return $this->asUserId($user_id);
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

    public function addParameters(array $parameters)
    {
        $this->adapter->addParameters($parameters);
        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->adapter->setParameters([]);
        return $this;
    }

    public function getParameters()
    {
        return $this->adapter->getParameters();
    }
}
