<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/accounts.html
 */
class Accounts implements CanvasApiClientInterface
{
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function listAccounts()
    {
        return [
            'accounts',
            'get'
        ];
    }

    public function listAccountsForCourseAdmins()
    {
        return [
            'course_accounts',
            'get'
        ];
    }

    public function getSingleAccount($id)
    {
        return [
            'accounts/' . $id,
            'get'
        ];
    }

    // alias
    public function getAccount($id)
    {
        return $this->getSingleAccount($id);
    }

    public function permissions($account_id)
    {
        return [
            'accounts/' . $account_id . '/permissions',
            'get'
        ];
    }

    // alias
    public function listPermissions($account_id)
    {
        return [
            'accounts/' . $account_id . '/permissions',
            'get'
        ];
    }

    public function getSubaccounts($account_id)
    {
        return [
            'accounts/' . $account_id . '/sub_accounts',
            'get'
        ];
    }

    public function getTermsOfService($account_id)
    {
        return [
            'accounts/' . $account_id . '/terms_of_service',
            'get'
        ];
    }

    public function getHelpLinks($account_id)
    {
        return [
            'accounts/' . $account_id . '/help_links',
            'get'
        ];
    }

    public function listActiveCoursesInAccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/courses',
            'get'
        ];
    }

    public function updateAccount($id)
    {
        return [
            'accounts/' . $id,
            'put'
        ];
    }

    public function deleteUserFromRootAccount($account_id, $user_id)
    {
        return [
            'accounts/' . $account_id . '/users/' . $user_id,
            'delete'
        ];
    }

    public function createSubaccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/sub_accounts',
            'post',
            ['account.name']
        ];
    }

    public function deleteSubaccount($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/sub_accounts/' . $id,
            'delete'
        ];
    }
}
