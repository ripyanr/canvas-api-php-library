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
        $this->adapter->addParameters(['as_user_id' => $user_id]);
        return;
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
        $this->adapter->addParameters(['per_page' => $per_page]);
        return;
    }
}
