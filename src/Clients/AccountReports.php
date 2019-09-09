<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/reports.html
 */
class AccountReports implements CanvasApiClientInterface
{
    public function listAvailableReports($account_id)
    {
        return [
            'accounts/' . $account_id . '/reports',
            'get'
        ];
    }

    public function startReport($account_id, $report)
    {
        return [
            'accounts/' . $account_id . '/reports/' . $report,
            'post'
        ];
    }

    public function getIndexOfReport($account_id, $report)
    {
        return [
            'accounts/' . $account_id . '/reports/' . $report,
            'get'
        ];
    }

    public function getStatusOfReport($account_id, $report, $id)
    {
        return [
            'accounts/' . $account_id . '/reports/' . $report . '/' . $id,
            'get'
        ];
    }

    public function deleteReport($account_id, $report, $id)
    {
        return [
            'accounts/' . $account_id . '/reports/' . $report . '/' . $id,
            'delete'
        ];
    }
}
