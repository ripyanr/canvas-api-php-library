<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/quizzes.html
 */
class Quizzes extends CanvasApiClient
{
    public function listQuizzesInCourse($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/quizzes'));
    }

    public function getSingleQuiz($course_id, $id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/quizzes/' . $id));
    }

    // alias
    public function getQuiz($course_id, $id)
    {
        return $this->getSingleQuiz($course_id, $id);
    }

    public function createQuiz($course_id)
    {
        $this->setRequiredParameters(['quiz.title']);
        return new CanvasApiResult($this->post('courses/' . $course_id . '/quizzes'));
    }

    public function editQuiz($course_id, $id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id . '/quizzes/' . $id));
    }

    public function deleteQuiz($course_id, $id)
    {
        return new CanvasApiResult($this->delete('courses/' . $course_id . '/quizzes/' . $id));
    }

    public function reorderQuizItems($course_id, $id)
    {
        // TODO: accept wildcards when validating params?
        // $this->setRequiredParameters(['order']);
        return new CanvasApiResult($this->post('courses/' . $course_id . '/quizzes/' . $id . '/reorder'));
    }

    public function validateQuizAccessCode($course_id, $id)
    {
        $this->setRequiredParameters(['access_code']);
        return new CanvasApiResult($this->post('courses/' . $course_id . '/quizzes/' . $id . '/validate_access_code'));
    }
}
