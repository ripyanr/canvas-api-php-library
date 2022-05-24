<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\Clients\CanvasApiClientInterface;

/**
 * https://canvas.instructure.com/doc/api/users.html
 */
class Logins implements CanvasApiClientInterface
{
    public function listUserLogins($user_id)
    {
        return [
            'users/'.$user_id.'/logins',
            'get'
        ];
    }

    public function createUserLogin($account_id)
    {
        return [
            'accounts/'.$account_id.'/logins',
            'post',
            ['user.id','login.unique_id']
        ];
    }

    public function editUserLogin($account_id, $id)
    {
        return [
            'accounts/'.$account_id.'/logins/'.$id,
            'put'
        ];
    }

    public function deleteUserLogin($user_id, $id)
    {
        return [
            'users/'.$user_id.'/logins/'.$id,
            'delete'
        ];
    }
}
