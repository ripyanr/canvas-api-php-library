<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/enrollments.html
 */
class Enrollments extends CanvasApiClient
{
    public function listCourseEnrollments($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/enrollments'));
    }

    public function listSectionEnrollments($section_id)
    {
        return new CanvasApiResult($this->get('sections/' . $section_id . '/enrollments'));
    }

    public function listUserEnrollments($user_id)
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/enrollments'));
    }

    public function getEnrollmentById($account_id, $id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/enrollments/' . $id));
    }

    // alias
    public function getEnrollment($account_id, $id)
    {
        return $this->getEnrollmentById($account_id, $id);
    }

    public function enrollUserInCourse($course_id)
    {
        $this->setRequiredParameters(['enrollment.user_id', 'enrollment.type']);
        return new CanvasApiResult($this->post('courses/' . $course_id . '/enrollments'));
    }

    public function enrollUserInSection($section_id)
    {
        $this->setRequiredParameters(['enrollment.user_id', 'enrollment.type']);
        return new CanvasApiResult($this->post('sections/' . $section_id . '/enrollments'));
    }

    public function concludeDeactivateOrDeleteEnrollment($course_id, $id)
    {
        return new CanvasApiResult($this->delete('courses/' . $course_id . '/enrollments/' . $id));
    }

    // helper
    public function concludeEnrollment($course_id, $id)
    {
        $this->setParameters(['task' => 'conclude']);
        return $this->concludeDeactivateOrDeleteEnrollment($course_id, $id);
    }

    // helper
    public function deleteEnrollment($course_id, $id)
    {
        $this->setParameters(['task' => 'delete']);
        return $this->concludeDeactivateOrDeleteEnrollment($course_id, $id);
    }

    // helper
    public function deactivateEnrollment($course_id, $id)
    {
        $this->setParameters(['task' => 'deactivate']);
        return $this->concludeDeactivateOrDeleteEnrollment($course_id, $id);
    }

    // helper, alias for deactivate
    public function inactivateEnrollment($course_id, $id)
    {
        $this->setParameters(['task' => 'inactivate']);
        return $this->concludeDeactivateOrDeleteEnrollment($course_id, $id);
    }

    public function acceptCourseInvitation($course_id, $id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/enrollments/' . $id . '/accept'));
    }

    public function rejectCourseInvitation($course_id, $id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/enrollments/' . $id . '/reject'));
    }

    public function addLastAttendedDateToEnrollment($course_id, $user_id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id . '/users/' . $user_id . '/last_attended'));
    }
}
