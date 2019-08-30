<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/analytics.html
 */
class Analytics implements CanvasApiClientInterface
{
    public function getDepartmentLevelParticipationData($account_id, $term_id = null)
    {
        if (is_numeric($term_id)) {
            $term_id = 'terms/' . $term_id;
        }
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/analytics/' . $term_id . '/activity'));
    }

    public function getDepartmentLevelGradeData($account_id, $term_id = null)
    {
        if (is_numeric($term_id)) {
            $term_id = 'terms/' . $term_id;
        }
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/analytics/' . $term_id . '/grades'));
    }

    public function getDepartmentLevelStatistics($account_id, $term_id = null)
    {
        if (is_numeric($term_id)) {
            $term_id = 'terms/' . $term_id;
        }
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/analytics/' . $term_id . '/statistics'));
    }

    public function getCourseLevelParticipationData($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/analytics/activity'));
    }

    public function getCourseLevelAssignmentData($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/analytics/assignments'));
    }

    public function getCourseLevelStudentSummaryData($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/analytics/student_summaries'));
    }

    public function getUserInCourseLevelParticipationData($course_id, $student_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/analytics/users/' . $student_id . '/activity'));
    }

    public function getUserInCourseLevelAssignmentData($course_id, $student_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/analytics/users/' . $student_id . '/assignments'));
    }

    public function getUserInCourseLevelMessagingData($course_id, $student_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/analytics/users/' . $student_id . '/communication'));
    }
}
