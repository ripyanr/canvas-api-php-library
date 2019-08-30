<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;
use Uncgits\CanvasApi\Traits\HasApiAdapter;

/**
 * https://canvas.instructure.com/doc/api/accounts.html
 */
class Accounts implements CanvasApiClientInterface
{
    use HasApiAdapter;
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function listAccounts()
    {
        return new CanvasApiResult($this->get('accounts'));
    }

    public function listAccountsForCourseAdmins()
    {
        return new CanvasApiResult($this->get('course_accounts'));
    }

    public function getSingleAccount($id)
    {
        return new CanvasApiResult($this->get('accounts/' . $id));
    }

    // alias
    public function getAccount($id)
    {
        return $this->getSingleAccount($id);
    }

    public function permissions($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/permissions'));
    }

    // alias
    public function listPermissions($account_id)
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

    public function listActiveCoursesInAccount($account_id)
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
        $this->setRequiredParameters(['account.name']);
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/sub_accounts'));
    }

    public function deleteSubaccount($account_id, $id)
    {
        return new CanvasApiResult($this->delete('accounts/' . $account_id . '/sub_accounts/' . $id));
    }
}
