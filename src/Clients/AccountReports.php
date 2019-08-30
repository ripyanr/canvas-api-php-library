<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;
use Uncgits\CanvasApi\Traits\HasApiAdapter;

/**
 * https://canvas.instructure.com/doc/api/reports.html
 */
class AccountReports implements CanvasApiClientInterface
{
    use HasApiAdapter;

    public function listAvailableReports($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/reports'));
    }

    public function startReport($account_id, $report)
    {
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/reports/' . $report));
    }

    public function getIndexOfReport($account_id, $report)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/reports/' . $report));
    }

    public function getStatusOfReport($account_id, $report, $id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/reports/' . $report . '/' . $id));
    }

    public function deleteReport($account_id, $report, $id)
    {
        return new CanvasApiResult($this->delete('accounts/' . $account_id . '/reports/' . $report . '/' . $id));
    }
}
