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

    public function listAccounts($includes = [])
    {
        $result = (new CanvasApiResult)
            ->setCalls($this->paginate('accounts', 'get'));

        $content = [];
        foreach ($result->getCalls() as $call) {
            if (isset($call['response']['body']) && !empty($call['response']['body'])) {
                $content = array_merge($content, $call['response']['body']);
            }
        }
        $result->content = $content;

        return $result;
    }
}
