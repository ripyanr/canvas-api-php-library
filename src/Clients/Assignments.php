<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/assignments.html
 */
class Assignments implements CanvasApiClientInterface
{
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function deleteAssignment($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $id,
            'delete'
        ];
    }

    public function listAssignments($course_id)
    {
        return [
            'courses/' . $course_id . '/assignments',
            'get'
        ];
    }

    public function listAssignmentsForUser($user_id, $course_id)
    {
        return [
            'users/' . $user_id . '/courses/' . $course_id . '/assignments',
            'get'
        ];
    }

    public function getSingleAssignment($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $id,
            'get'
        ];
    }

    // alias
    public function getAssignment($course_id, $id)
    {
        return $this->getSingleAssignment($course_id, $id);
    }

    public function createAssignment($course_id)
    {
        return [
            'courses/' . $course_id . '/assignments',
            'post',
            ['assignment.name']
        ];
    }

    public function editAssignment($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $id,
            'put'
        ];
    }

    public function listAssignmentOverrides($course_id, $assignment_id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides',
            'get'
        ];
    }

    public function getSingleAssignmentOverride($course_id, $assignment_id, $id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides/' . $id,
            'get'
        ];
    }

    // alias
    public function getAssignmentOverride($course_id, $assignment_id, $id)
    {
        return $this->getSingleAssignmentOverride($course_id, $assignment_id, $id);
    }

    public function redirectToAssignmentOverrideForGroup($group_id, $assignment_id)
    {
        return [
            'groups/' . $group_id . '/assignments/' . $assignment_id . '/override',
            'get'
        ];
    }

    public function redirectToAssignmentOverrideForSection($course_section_id, $assignment_id)
    {
        return [
            'sections/' . $course_section_id . '/assignments/' . $assignment_id . '/override',
            'get'
        ];
    }

    public function createAssignmentOverride($course_id, $assignment_id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides',
            'post'
        ];
    }

    public function updateAssignmentOverride($course_id, $assignment_id, $id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides/' . $id,
            'put'
        ];
    }

    public function deleteAssignmentOverride($course_id, $assignment_id, $id)
    {
        return [
            'courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides/' . $id,
            'delete'
        ];
    }

    public function batchRetrieveOverridesInCourse($course_id)
    {
        // TODO: validation on wildcard parameters
        return [
            'courses/' . $course_id . '/assignments/overrides',
            'get'
        ];
    }

    public function batchCreateOverridesInCourse($course_id)
    {
        // TODO: validation on wildcard parameters
        return [
            'courses/' . $course_id . '/assignments/overrides',
            'post'
        ];
    }

    public function batchUpdateOverridesInCourse($course_id)
    {
        // TODO: validation on wildcard parameters
        return [
            'courses/' . $course_id . '/assignments/overrides',
            'put'
        ];
    }
}
