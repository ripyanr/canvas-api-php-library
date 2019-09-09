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
        //TODO: wildcard parameter validation
        // $this->setRequiredParameters(['quiz_submissions.*.attempt']);
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id,
            'put'
        ];
    }

    public function completeQuizSubmission($course_id, $quiz_id, $id)
    {
        $this->setRequiredParameters(['attempt', 'validation_token']);
        return [
            'courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/complete',
            'post'
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
