<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/roles.html
 */
class Roles implements CanvasApiClientInterface
{
    public function listRoles($account_id)
    {
        return [
            'accounts/' . $account_id . '/roles',
            'get'
        ];
    }

    public function getRole($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/roles/' . $id,
            'get'
        ];
    }

    public function createRole($account_id)
    {
        return [
            'accounts/' . $account_id . '/roles',
            'post',
            ['label']
        ];
    }

    public function deactivateRole($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/roles/' . $id,
            'delete'
        ];
    }

    public function activateRole($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/roles/' . $id . '/activate',
            'post'
        ];
    }

    public function updateRole($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/roles/' . $id,
            'put',
            ['role_id']
        ];
    }
}
