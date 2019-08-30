<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/roles.html
 */
class Roles implements CanvasApiClientInterface
{
    public function listRoles($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/roles'));
    }

    public function getRole($account_id, $id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/roles/' . $id));
    }

    public function createRole($account_id)
    {
        $this->setRequiredParameters(['label']);
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/roles'));
    }

    public function deactivateRole($account_id, $id)
    {
        return new CanvasApiResult($this->delete('accounts/' . $account_id . '/roles/' . $id));
    }

    public function activateRole($account_id, $id)
    {
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/roles/' . $id . '/activate'));
    }

    public function updateRole($account_id, $id)
    {
        // $this->setRequiredParameters(['role_id']);
        return new CanvasApiResult($this->put('accounts/' . $account_id . '/roles/' . $id));
    }
}
