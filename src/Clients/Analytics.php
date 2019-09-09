<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/analytics.html
 */
class Analytics implements CanvasApiClientInterface
{
    public function getDepartmentLevelParticipationData($account_id, $term_id = null)
    {
        return [
            'accounts/' . $account_id . '/analytics/' . $this->parseTerm($term_id) . 'activity',
            'get'
        ];
    }

    public function getDepartmentLevelGradeData($account_id, $term_id = null)
    {
        return [
            'accounts/' . $account_id . '/analytics/' . $this->parseTerm($term_id) . 'grades',
            'get'
        ];
    }

    public function getDepartmentLevelStatistics($account_id, $term_id = null)
    {
        return [
            'accounts/' . $account_id . '/analytics/' . $this->parseTerm($term_id) . 'statistics',
            'get'
        ];
    }

    public function getCourseLevelParticipationData($course_id)
    {
        return [
            'courses/' . $course_id . '/analytics/activity',
            'get'
        ];
    }

    public function getCourseLevelAssignmentData($course_id)
    {
        return [
            'courses/' . $course_id . '/analytics/assignments',
            'get'
        ];
    }

    public function getCourseLevelStudentSummaryData($course_id)
    {
        return [
            'courses/' . $course_id . '/analytics/student_summaries',
            'get'
        ];
    }

    public function getUserInCourseLevelParticipationData($course_id, $student_id)
    {
        return [
            'courses/' . $course_id . '/analytics/users/' . $student_id . '/activity',
            'get'
        ];
    }

    public function getUserInCourseLevelAssignmentData($course_id, $student_id)
    {
        return [
            'courses/' . $course_id . '/analytics/users/' . $student_id . '/assignments',
            'get'
        ];
    }

    public function getUserInCourseLevelMessagingData($course_id, $student_id)
    {
        return [
            'courses/' . $course_id . '/analytics/users/' . $student_id . '/communication',
            'get'
        ];
    }

    private function parseTerm($term_id)
    {
        if (is_numeric($term_id)) {
            return 'terms/' . $term_id . '/';
        }

        return '';
    }
}
