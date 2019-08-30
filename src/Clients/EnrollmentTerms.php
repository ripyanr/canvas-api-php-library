<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/enrollment_terms.html
 */
class EnrollmentTerms implements CanvasApiClientInterface
{
    public function createEnrollmentTerm($account_id)
    {
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/terms'));
    }

    public function updateEnrollmentTerm($account_id, $id)
    {
        return new CanvasApiResult($this->put('accounts/' . $account_id . '/terms/' . $id));
    }

    public function deleteEnrollmentTerm($account_id, $id)
    {
        return new CanvasApiResult($this->delete('accounts/' . $account_id . '/terms/' . $id));
    }

    public function listEnrollmentTerms($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/terms'));
    }
}
