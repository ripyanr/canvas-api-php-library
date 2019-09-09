<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/quizzes.html
 */
class Quizzes implements CanvasApiClientInterface
{
    public function listQuizzesInCourse($course_id)
    {
        return [
            'courses/' . $course_id . '/quizzes',
            'get'
        ];
    }

    public function getSingleQuiz($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $id,
            'get'
        ];
    }

    // alias
    public function getQuiz($course_id, $id)
    {
        return $this->getSingleQuiz($course_id, $id);
    }

    public function createQuiz($course_id)
    {
        $this->setRequiredParameters(['quiz.title']);
        return [
            'courses/' . $course_id . '/quizzes',
            'post'
        ];
    }

    public function editQuiz($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $id,
            'put'
        ];
    }

    public function deleteQuiz($course_id, $id)
    {
        return [
            'courses/' . $course_id . '/quizzes/' . $id,
            'delete'
        ];
    }

    public function reorderQuizItems($course_id, $id)
    {
        // TODO: accept wildcards when validating params?
        // $this->setRequiredParameters(['order']);
        return [
            'courses/' . $course_id . '/quizzes/' . $id . '/reorder',
            'post'
        ];
    }

    public function validateQuizAccessCode($course_id, $id)
    {
        $this->setRequiredParameters(['access_code']);
        return [
            'courses/' . $course_id . '/quizzes/' . $id . '/validate_access_code',
            'post'
        ];
    }
}
