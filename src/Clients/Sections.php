<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/sections.html
 */
class Sections implements CanvasApiClientInterface
{
    public function listCourseSections($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/sections'));
    }

    public function createCourseSection($course_id)
    {
        return new CanvasApiResult($this->post('courses/' . $course_id . '/sections'));
    }

    public function crossListSection($id, $new_course_id)
    {
        return new CanvasApiResult($this->post('sections/' . $id . '/crosslist/' . $new_course_id));
    }

    public function deCrossListSection($id)
    {
        return new CanvasApiResult($this->delete('sections/' . $id . '/crosslist'));
    }

    public function editSection($id)
    {
        return new CanvasApiResult($this->put('sections/' . $id));
    }

    // the arguments are reversed here since $course_id is optional.
    public function getSectionInformation($id, $course_id = null)
    {
        if (is_null($course_id)) {
            return new CanvasApiResult($this->get('sections/' . $id));
        }

        return new CanvasApiResult($this->get('courses/' . $course_id . '/sections/' . $id));
    }

    public function deleteSection($id)
    {
        return new CanvasApiResult($this->delete('sections/' . $id));
    }
}
