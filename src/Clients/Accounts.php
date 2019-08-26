<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/accounts.html
 */
class Accounts extends CanvasApiClient
{
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function listAccounts()
    {
        return new CanvasApiResult($this->get('accounts'));
    }

    public function getAccount($id)
    {
        return new CanvasApiResult($this->get('accounts/' . $id));
    }

    public function getPermissions($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/permissions'));
    }

    public function getSubaccounts($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/sub_accounts'));
    }

    public function getTermsOfService($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/terms_of_service'));
    }

    public function getHelpLinks($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/help_links'));
    }

    public function getActiveCourses($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/courses'));
    }

    public function updateAccount($id)
    {
        return new CanvasApiResult($this->put('accounts/' . $id));
    }

    public function deleteUserFromRootAccount($account_id, $user_id)
    {
        return new CanvasApiResult($this->delete('accounts/' . $account_id . '/users/' . $user_id));
    }

    public function createSubaccount($account_id)
    {
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/sub_accounts'));
    }

    public function deleteSubaccount($account_id, $id)
    {
        return new CanvasApiResult($this->delete('accounts/' . $account_id . '/sub_accounts/' . $id));
    }
}
