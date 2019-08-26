<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/courses.html
 */
class Courses extends CanvasApiClient
{
    public function listCourses()
    {
        return new CanvasApiResult($this->get('courses'));
    }

    public function listCoursesForUser($user_id)
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/courses'));
    }

    public function createCourse($account_id)
    {
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/courses'));
    }

    public function uploadFile($course_id)
    {
        // TODO: multi-step process to get AWS address and key - skip for now.
    }

    // alias for the deprecated endpoint
    public function listStudents($course_id)
    {
        $this->addParameters(['enrollment_type' => ['student']]);
        return $this->listUsers($course_id);
    }

    public function listUsers($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/students'));
    }

    public function listRecentlyLoggedInStudents($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/recent_students'));
    }

    public function getSingleUser($course_id, $id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/users/' . $id));
    }

    public function previewProcessedHtml($course_id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/preview_html'));
    }

    public function getCourseActivityStream($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/activity_stream'));
    }

    public function getCourseActivityStreamSummary($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/activity_stream/summary'));
    }

    public function getCourseTodoItems($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/todo'));
    }

    public function deleteOrConcludeCourse($course_id)
    {
        return new CanvasApiResult($this->delete('courses/' . $course_id));
    }

    // helper
    public function deleteCourse($course_id)
    {
        $this->setParameters(['event' => 'delete']);
        return $this->deleteOrConcludeCourse($course_id);
    }

    // helper
    public function concludeCourse($course_id)
    {
        $this->setParameters(['event' => 'conclude']);
        return $this->deleteOrConcludeCourse($course_id);
    }

    public function getCourseSettings($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/settings'));
    }

    public function updateCourseSettings($course_id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id . '/settings'));
    }

    public function getCourse($course_id, $account_id = null)
    {
        if (!is_null($account_id)) {
            return new CanvasApiResult($this->get('accounts/ ' . $account_id . '/courses/' . $course_id));
        }
        return new CanvasApiResult($this->get('courses/' . $course_id));
    }

    public function updateCourse($course_id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id));
    }

    public function updateCourses($account_id)
    {
        // note, must use the progress endpoint to check the status of this.
        return new CanvasApiResult($this->put('accounts/' . $account_id . '/courses'));
    }

    public function resetCourse($course_id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/reset_content'));
    }

    public function getEffectiveDueDates($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/effective_due_dates'));
    }

    public function getPermissions($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/permissions'));
    }

    // TODO: deprecated. alias this to the content migrations API
    public function getCoruseCopyStatus($course_id, $id)
    {
    }

    // TODO: deprecated. alias this to the content migrations API
    public function copyCourseContent($course_id)
    {
    }
}
