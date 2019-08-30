<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/quiz_submissions.html
 */
class QuizSubmissions implements CanvasApiClientInterface
{
    public function getAllQuizSubmissions($course_id, $quiz_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions'));
    }

    public function getQuizSubmission($course_id, $quiz_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submission'));
    }

    public function getSingleQuizSubmission($course_id, $quiz_id, $id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id));
    }

    public function createQuizSubmission($course_id, $quiz_id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions'));
    }

    public function updateStudentQuestionScoresAndComments($course_id, $quiz_id, $id)
    {
        //TODO: wildcard parameter validation
        // $this->setRequiredParameters(['quiz_submissions.*.attempt']);
        return new CanvasApiResult($this->put('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id));
    }

    public function completeQuizSubmission($course_id, $quiz_id, $id)
    {
        $this->setRequiredParameters(['attempt', 'validation_token']);
        return new CanvasApiResult($this->post('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/complete'));
    }

    public function getCurrentQuizSubmissionTimes($course_id, $quiz_id, $id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/quizzes/' . $quiz_id . '/submissions/' . $id . '/time'));
    }
}
