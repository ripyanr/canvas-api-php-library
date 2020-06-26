<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/quiz_submission_events.html
 */
class QuizSubmissionEvents implements CanvasApiClientInterface
{
    public function submitCapturedEvents($course_id, $quiz_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/events',
            'post'
        ];
    }

    public function retrieveCapturedEvents($course_id, $quiz_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/events',
            'get'
        ];
    }
}
