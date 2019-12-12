<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/sis_imports.html
 */
class SisImports implements CanvasApiClientInterface
{
    public function getSisImportList($account_id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports',
            'get'
        ];
    }

    public function getCurrentImportingSisImport($account_id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports/importing',
            'get'
        ];
    }

    public function importSisData($account_id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports',
            'post'
        ];
    }

    public function getSisImportStatus($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports/' . $id,
            'get'
        ];
    }

    public function restoreWorkflowStatesOfSisImportedItems($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports/' . $id . '/restore_states',
            'put'
        ];
    }

    public function abortSisImport($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports/' . $id . '/abort',
            'put'
        ];
    }

    public function abortAllPendingSisImports($account_id)
    {
        return [
            'accounts/' . $account_id . '/sis_imports/abort_all_pending',
            'put'
        ];
    }
}
