<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/courses.html
 */
class Courses implements CanvasApiClientInterface
{
    public function listCourses()
    {
        return [
            'courses',
            'get'
        ];
    }

    public function listCoursesForUser($user_id)
    {
        return [
            'users/' . $user_id . '/courses',
            'get'
        ];
    }

    public function createCourse($account_id)
    {
        return [
            'accounts/' . $account_id . '/courses',
            'post'
        ];
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
        return [
            'courses/' . $course_id . '/students',
            'get'
        ];
    }

    public function listRecentlyLoggedInStudents($course_id)
    {
        return [
            'courses/' . $course_id . '/recent_students',
            'get'
        ];
    }

    public function getSingleUser($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/users/' . $id,
            'get'
        ];
    }

    // alias
    public function getUser($course_id, $id)
    {
        return $this->getSingleUser($course_id, $id);
    }

    public function previewProcessedHtml($course_id)
    {
        return [
            'courses/' . $course_id . '/preview_html',
            'post'
        ];
    }

    public function getCourseActivityStream($course_id)
    {
        return [
            'courses/' . $course_id . '/activity_stream',
            'get'
        ];
    }

    public function getCourseActivityStreamSummary($course_id)
    {
        return [
            'courses/' . $course_id . '/activity_stream/summary',
            'get'
        ];
    }

    public function getCourseTodoItems($course_id)
    {
        return [
            'courses/' . $course_id . '/todo',
            'get'
        ];
    }

    public function deleteOrConcludeCourse($course_id)
    {
        return [
            'courses/' . $course_id,
            'delete',
            ['event']
        ];
    }

    public function getCourseSettings($course_id)
    {
        return [
            'courses/' . $course_id . '/settings',
            'get'
        ];
    }

    public function updateCourseSettings($course_id)
    {
        return [
            'courses/' . $course_id . '/settings',
            'put'
        ];
    }

    public function getCourse($course_id, $account_id = null)
    {
        if (!is_null($account_id)) {
            return [
                'accounts/ ' . $account_id . '/courses/' . $course_id,
                'get'
            ];
        }
        return [
            'courses/' . $course_id,
            'get'
        ];
    }

    public function updateCourse($course_id)
    {
        return [
            'courses/' . $course_id,
            'put'
        ];
    }

    public function updateCourses($account_id)
    {
        // note, must use the progress endpoint to check the status of this.
        return [
            'accounts/' . $account_id . '/courses',
            'put',
            ['course_ids', 'event']
        ];
    }

    public function resetCourse($course_id)
    {
        return [
            'courses/' . $course_id . '/reset_content',
            'post'
        ];
    }

    public function getEffectiveDueDates($course_id)
    {
        return [
            'courses/' . $course_id . '/effective_due_dates',
            'get'
        ];
    }

    public function getPermissions($course_id)
    {
        return [
            'courses/' . $course_id . '/permissions',
            'get'
        ];
    }

    public function getUserProgress($course_id, $user_id)
    {
        return [
            'courses/' . $course_id . '/users/' . $user_id . '/progress',
            'get'
        ];
    }

    

    // TODO: deprecated. alias this to the content migrations API
    public function getCourseCopyStatus($course_id, $id)
    {
    }

    // TODO: deprecated. alias this to the content migrations API
    public function copyCourseContent($course_id)
    {
    }
}
