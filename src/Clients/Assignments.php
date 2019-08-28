<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/assignments.html
 */
class Assignments extends CanvasApiClient
{
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function deleteAssignment($course_id, $id)
    {
        return new CanvasApiResult($this->delete('courses/' . $course_id . '/assignments/' . $id));
    }

    public function listAssignments($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/assignments'));
    }

    public function listAssignmentsForUser($user_id, $course_id)
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/courses/' . $course_id . '/assignments'));
    }

    public function getSingleAssignment($course_id, $id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/assignments/' . $id));
    }

    // alias
    public function getAssignment($course_id, $id)
    {
        return $this->getSingleAssignment($course_id, $id);
    }

    public function createAssignment($course_id)
    {
        $this->setRequiredParameters(['assignment.name']);
        return new CanvasApiResult($this->post('courses/' . $course_id . '/assignments'));
    }

    public function editAssignment($course_id, $id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id . '/assignments/' . $id));
    }

    public function listAssignmentOverrides($course_id, $assignment_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides'));
    }

    public function getSingleAssignmentOverride($course_id, $assignment_id, $id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides/' . $id));
    }

    // alias
    public function getAssignmentOverride($course_id, $assignment_id, $id)
    {
        return $this->getSingleAssignmentOverride($course_id, $assignment_id, $id);
    }

    public function redirectToAssignmentOverrideForGroup($group_id, $assignment_id)
    {
        return new CanvasApiResult($this->get('groups/' . $group_id . '/assignments/' . $assignment_id . '/override'));
    }

    public function redirectToAssignmentOverrideForSection($course_section_id, $assignment_id)
    {
        return new CanvasApiResult($this->get('sections/' . $course_section_id . '/assignments/' . $assignment_id . '/override'));
    }

    public function createAssignmentOverride($course_id, $assignment_id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides'));
    }

    public function updateAssignmentOverride($course_id, $assignment_id, $id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides/' . $id));
    }

    public function deleteAssignmentOverride($course_id, $assignment_id, $id)
    {
        return new CanvasApiResult($this->delete('courses/' . $course_id . '/assignments/' . $assignment_id . '/overrides/' . $id));
    }

    public function batchRetrieveOverridesInCourse($course_id)
    {
        // TODO: validation on wildcard parameters
        return new CanvasApiResult($this->get('courses/' . $course_id . '/assignments/overrides'));
    }

    public function batchCreateOverridesInCourse($course_id)
    {
        // TODO: validation on wildcard parameters
        return new CanvasApiResult($this->post('courses/' . $course_id . '/assignments/overrides'));
    }

    public function batchUpdateOverridesInCourse($course_id)
    {
        // TODO: validation on wildcard parameters
        return new CanvasApiResult($this->put('courses/' . $course_id . '/assignments/overrides'));
    }
}
