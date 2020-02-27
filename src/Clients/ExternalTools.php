<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/external_tools.html
 */
class ExternalTools implements CanvasApiClientInterface
{
    public function listExternalToolsForAccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/external_tools',
            'get'
        ];
    }

    public function listExternalToolsForCourse($course_id)
    {
        return [
            'courses/' . $course_id . '/external_tools',
            'get'
        ];
    }

    public function listExternalToolsForGroup($group_id)
    {
        return [
            'groups/' . $group_id . '/external_tools',
            'get'
        ];
    }

    public function getSessionlessLaunchUrlForToolInAccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/external_tools/sessionless_launch',
            'get',
            ['id']
        ];
    }

    public function getSessionlessLaunchUrlForToolInCourse($course_id)
    {
        return [
            'courses/' . $course_id . '/external_tools/sessionless_launch',
            'get',
            ['id']
        ];
    }

    public function getSingleExternalToolInCourse($course_id, $external_tool_id)
    {
        return [
            'courses/' . $course_id . '/external_tools/' . $external_tool_id,
            'get'
        ];
    }

    public function getSingleExternalToolInAccount($account_id, $external_tool_id)
    {
        return [
            'accounts/' . $account_id . '/external_tools/' . $external_tool_id,
            'get'
        ];
    }

    public function createExternalToolInCourse($course_id)
    {
        return [
            'courses/' . $course_id . '/external_tools',
            'post',
            ['client_id', 'name', 'privacy_level', 'consumer_key', 'shared_secret']
        ];
    }

    public function createExternalToolInAccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/external_tools',
            'post',
            ['client_id', 'name', 'privacy_level', 'consumer_key', 'shared_secret']
        ];
    }

    public function editExternalToolInCourse($course_id, $external_tool_id)
    {
        return [
            'courses/' . $course_id . '/external_tools/' . $external_tool_id,
            'put',
        ];
    }

    public function editExternalToolInAccount($account_id, $external_tool_id)
    {
        return [
            'accounts/' . $account_id . '/external_tools/' . $external_tool_id,
            'put',
        ];
    }

    public function deleteExternalToolInCourse($course_id, $external_tool_id)
    {
        return [
            'courses/' . $course_id . '/external_tools/' . $external_tool_id,
            'put',
        ];
    }

    public function deleteExternalToolInAccount($account_id, $external_tool_id)
    {
        return [
            'accounts/' . $account_id . '/external_tools/' . $external_tool_id,
            'put',
        ];
    }
}
