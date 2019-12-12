<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/sis_import_errors.html
 */
class SisImportErrors implements CanvasApiClientInterface
{
    public function getSisImportErrorList($account_id, $id = null)
    {
        $suffix = is_null($id) ? 'sis_import_errors' : 'sis_imports/' . $id . '/errors';

        return [
            'accounts/' . $account_id . '/sis_imports/' . $suffix,
            'get'
        ];
    }
}
