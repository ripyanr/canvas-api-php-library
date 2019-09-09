<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/enrollments.html
 */
class Enrollments implements CanvasApiClientInterface
{
    public function listCourseEnrollments($course_id)
    {
        return [
            'courses/' . $course_id . '/enrollments',
            'get'
        ];
    }

    public function listSectionEnrollments($section_id)
    {
        return [
            'sections/' . $section_id . '/enrollments',
            'get'
        ];
    }

    public function listUserEnrollments($user_id)
    {
        return [
            'users/' . $user_id . '/enrollments',
            'get'
        ];
    }

    public function getEnrollmentById($account_id, $id)
    {
        return [
            'accounts/' . $account_id . '/enrollments/' . $id,
            'get'
        ];
    }

    // alias
    public function getEnrollment($account_id, $id)
    {
        return $this->getEnrollmentById($account_id, $id);
    }

    public function enrollUserInCourse($course_id)
    {
        $this->setRequiredParameters(['enrollment.user_id', 'enrollment.type']);
        return [
            'courses/' . $course_id . '/enrollments',
            'post'
        ];
    }

    public function enrollUserInSection($section_id)
    {
        $this->setRequiredParameters(['enrollment.user_id', 'enrollment.type']);
        return [
            'sections/' . $section_id . '/enrollments',
            'post'
        ];
    }

    public function concludeDeactivateOrDeleteEnrollment($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/enrollments/' . $id,
            'delete'
        ];
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
        return [
            'courses/' . $course_id . '/enrollments/' . $id . '/accept',
            'post'
        ];
    }

    public function rejectCourseInvitation($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/enrollments/' . $id . '/reject',
            'post'
        ];
    }

    public function addLastAttendedDateToEnrollment($course_id, $user_id)
    {
        return [
            'courses/' . $course_id . '/users/' . $user_id . '/last_attended',
            'put'
        ];
    }
}
