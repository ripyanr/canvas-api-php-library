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

    public function listAccounts($parameters = [])
    {
        $this->setParameters($parameters);
        return new CanvasApiResult($this->paginate('accounts', 'get'));
    }

    public function getAccount($id)
    {
        return new CanvasApiResult($this->call('accounts/' . $id, 'get'));
    }

    public function getPermissions($account_id, $parameters = [])
    {
        $this->setParameters($parameters);
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/permissions', 'get'));
    }

    public function getSubaccounts($account_id, $parameters = [])
    {
        $this->setParameters($parameters);
        return new CanvasApiResult($this->paginate('accounts/' . $account_id . '/sub_accounts', 'get'));
    }

    public function getTermsOfService($account_id)
    {
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/terms_of_service', 'get'));
    }

    public function getHelpLinks($account_id)
    {
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/help_links', 'get'));
    }

    public function getActiveCourses($account_id, $parameters = [])
    {
        $this->setParameters($parameters);
        return new CanvasApiResult($this->paginate('accounts/' . $account_id . '/courses', 'get'));
    }

    public function updateAccount($id, $parameters = [])
    {
        $this->setParameters($parameters);
        return new CanvasApiResult($this->call('accounts/' . $id, 'put'));
    }

    public function deleteUserFromRootAccount($account_id, $user_id)
    {
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/users/' . $user_id, 'delete'));
    }

    public function createSubaccount($account_id, $parameters = [])
    {
        $this->setParameters($parameters);
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/sub_accounts', 'post'));
    }

    public function deleteSubaccount($account_id, $id)
    {
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/sub_accounts/' . $id, 'delete'));
    }
}
