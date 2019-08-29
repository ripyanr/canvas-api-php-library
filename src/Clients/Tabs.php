<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;
use Uncgits\CanvasApi\Traits\HasApiAdapter;

/**
 * https://canvas.instructure.com/doc/api/tabs.html
 */
class Tabs implements CanvasApiClientInterface
{
    use HasApiAdapter;

    public function listTabsForAccount($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/tabs'));
    }

    public function listTabsForCourse($course_id)
    {
        return new CanvasApiResult($this->get('courses/' . $course_id . '/tabs'));
    }

    public function listTabsForGroup($group_id)
    {
        return new CanvasApiResult($this->get('groups/' . $group_id . '/tabs'));
    }

    public function listTabsForUser($user_id)
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/tabs'));
    }

    public function updateTabForCourse($course_id, $tab_id)
    {
        return new CanvasApiResult($this->put('courses/' . $course_id . '/tabs/' . $tab_id));
    }
}
