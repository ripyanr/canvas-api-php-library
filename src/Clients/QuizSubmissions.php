<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/quiz_submissions.html
 */
class QuizSubmissions implements CanvasApiClientInterface
{
    public function getAllQuizSubmissions($course_id, $quiz_id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions',
            'get'
        ];
    }

    public function getQuizSubmission($course_id, $quiz_id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submission',
            'get'
        ];
    }

    public function getSingleQuizSubmission($course_id, $quiz_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id,
            'get'
        ];
    }

    public function createQuizSubmission($course_id, $quiz_id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions',
            'post'
        ];
    }

    public function updateStudentQuestionScoresAndComments($course_id, $quiz_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id,
            'put',
            // ['quiz_submissions.*.attempt'], //TODO: wildcard parameter validation
        ];
    }

    public function completeQuizSubmission($course_id, $quiz_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/complete',
            'post',
            ['attempt', 'validation_token']
        ];
    }

    public function getCurrentQuizSubmissionTimes($course_id, $quiz_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/time',
            'get'
        ];
    }
}
