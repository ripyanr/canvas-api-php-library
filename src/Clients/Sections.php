<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/sections.html
 */
class Sections implements CanvasApiClientInterface
{
    public function listCourseSections($course_id)
    {
        return [
            'courses/' . $course_id . '/sections',
            'get'
        ];
    }

    public function createCourseSection($course_id)
    {
        return [
            'courses/' . $course_id . '/sections',
            'post'
        ];
    }

    public function crossListSection($id, $new_course_id)
    {
        return [
            'sections/' . $id . '/crosslist/' . $new_course_id,
            'post'
        ];
    }

    public function deCrossListSection($id)
    {
        return [
            'sections/' . $id . '/crosslist',
            'delete'
        ];
    }

    public function editSection($id)
    {
        return [
            'sections/' . $id,
            'put'
        ];
    }

    // the arguments are reversed here since $course_id is optional.
    public function getSectionInformation($id, $course_id = null)
    {
        if (is_null($course_id)) {
            return [
                'sections/' . $id,
                'get'
            ];
        }

        return [
            'courses/' . $course_id . '/sections/' . $id,
            'get'
        ];
    }

    public function deleteSection($id)
    {
        return [
            'sections/' . $id,
            'delete'
        ];
    }
}
