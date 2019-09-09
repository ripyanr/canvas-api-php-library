<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/tabs.html
 */
class Tabs implements CanvasApiClientInterface
{
    public function listTabsForAccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/tabs',
            'get'
        ];
    }

    public function listTabsForCourse($course_id)
    {
        return [
            'courses/' . $course_id . '/tabs',
            'get'
        ];
    }

    public function listTabsForGroup($group_id)
    {
        return [
            'groups/' . $group_id . '/tabs',
            'get'
        ];
    }

    public function listTabsForUser($user_id)
    {
        return [
            'users/' . $user_id . '/tabs',
            'get'
        ];
    }

    public function updateTabForCourse($course_id, $tab_id)
    {
        return [
            'courses/' . $course_id . '/tabs/' . $tab_id,
            'put'
        ];
    }
}
