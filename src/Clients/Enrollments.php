<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/enrollments.html
 */
class Enrollments extends CanvasApiClient
{
    public function listEnrollments($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/enrollments'));
    }
}
