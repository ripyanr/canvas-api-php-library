<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/users.html
 */
class Users implements CanvasApiClientInterface
{
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function listUsersInAccount($account_id)
    {
        return [
            'accounts/' . $account_id . '/users',
            'get'
        ];
    }

    public function listActivityStream()
    {
        return [
            'users/self/activity_stream',
            'get'
        ];
    }

    public function activityStreamSummary()
    {
        return [
            'users/self/activity_stream/summary',
            'get'
        ];
    }

    public function listTodoItems()
    {
        return [
            'users/self/todo',
            'get'
        ];
    }

    public function listCountsForTodoItems()
    {
        return [
            'users/self/todo_item_count',
            'get'
        ];
    }

    public function listUpcomingAssignmentsAndCalendarEvents()
    {
        return [
            'users/self/upcoming_events',
            'get'
        ];
    }

    public function listMissingSubmissions($user_id = 'self')
    {
        return [
            'users/' . $user_id . '/missing_submissions',
            'get'
        ];
    }

    public function hideStreamItem($id)
    {
        return [
            'users/self/activity_stream/' . $id,
            'delete'
        ];
    }

    public function hideAllStreamItems()
    {
        return [
            'users/self/activity_stream',
            'delete'
        ];
    }

    public function uploadFile($user_id, $local_file_path)
    {
        // TODO: multi-step process to get AWS address and key - skip for now.
    }

    public function showUserDetails($id = 'self')
    {
        return [
            'users/' . $id, 'get'
        ];
    }

    // alias
    public function getUser($id = 'self')
    {
        return $this->showUserDetails($id);
    }

    public function createUser($account_id)
    {
        return [
            'accounts/' . $account_id . '/users',
            'post',
            ['pseudonym.unique_id']
        ];
    }

    public function selfRegisterUser($account_id)
    {
        return [
            'accounts/' . $account_id . '/self_registration',
            'post',
            ['user.name', 'user.terms_of_use', 'pseudonym.unique_id']
        ];
    }

    public function getUserSettings($id = 'self')
    {
        return [
            'users/' . $id . '/settings',
            'get'
        ];
    }

    public function updateUserSettings($id = 'self')
    {
        return [
            'users/' . $id . '/settings',
            'put'
        ];
    }

    public function getCustomColors($id = 'self')
    {
        return [
            'users/' . $id . '/colors',
            'get'
        ];
    }

    public function getCustomColor($id = 'self', $asset_string)
    {
        return [
            'users/' . $id . '/colors/' . $asset_string, 'get'
        ];
    }

    public function updateCustomColor($id = 'self', $asset_string)
    {
        return [
            'users/' . $id . '/colors/' . $asset_string, 'put'
        ];
    }

    // NOTE - listed as BETA endpoint
    public function getDashboardPositions($id = 'self')
    {
        return [
            'users/' . $id . '/dashboard_positions',
            'get'
        ];
    }

    // NOTE - listed as BETA endpoint
    public function updateDashboardPositions($id = 'self')
    {
        return [
            'users/' . $id . '/dashboard_positions',
            'put'
        ];
    }

    public function editUser($id = 'self')
    {
        return [
            'users/' . $id, 'put'
        ];
    }

    public function mergeUserIntoAnotherUser($id, $destination_user_id, $destination_account_id = null)
    {
        if (!is_null($destination_account_id)) {
            return [
                'users/' . $id . '/merge_into/accounts/' . $destination_account_id . '/users/' . $destination_user_id,
                'put'
            ];
        }
        return [
            'users/' . $id . '/merge_into/' . $destination_user_id,
            'put'
        ];
    }

    public function splitMergedUsersIntoSeparateUsers($id)
    {
        return [
            'users/' . $id . '/split',
            'post'
        ];
    }

    public function getPandataEventsJwtToken()
    {
        return [
            'users/self/pandata_events_token',
            'post'
        ];
    }

    public function getMostRecentlyGradedSubmissions($id = 'self')
    {
        return [
            'users/' . $id . '/graded_submissions',
            'get'
        ];
    }

    public function listAvatarOptions($user_id = 'self')
    {
        return [
            'users/' . $user_id . '/avatars',
            'get'
        ];
    }

    public function listUserPageViews($user_id = 'self')
    {
        return [
            'users/' . $user_id . '/page_views',
            'get'
        ];
    }

    public function storeCustomData($user_id = 'self', $scope = null)
    {
        return [
            'users/' . $user_id . '/custom_data' . $this->applyScope($scope),
            'put',
            ['ns', 'data']
        ];
    }

    public function loadCustomData($user_id = 'self', $scope = null)
    {
        return [
            'users/' . $user_id . '/custom_data' . $this->applyScope($scope),
            'get',
            ['ns']
        ];
    }

    public function deleteCustomData($user_id = 'self', $scope = null)
    {
        return [
            'users/' . $user_id . '/custom_data' . $this->applyScope($scope),
            'delete',
            ['ns']
        ];
    }

    public function listCourseNicknames()
    {
        return [
            'users/self/course_nicknames',
            'get'
        ];
    }

    public function getCourseNickname($course_id)
    {
        return [
            'users/self/course_nicknames/' . $course_id,
            'get'
        ];
    }

    public function setCourseNickname($course_id)
    {
        return [
            'users/self/course_nicknames/' . $course_id,
            'put',
            ['nickname']
        ];
    }

    public function removeCourseNickname($course_id)
    {
        return [
            'users/self/course_nicknames/' . $course_id,
            'delete'
        ];
    }

    public function clearCourseNicknames()
    {
        return [
            'users/self/course_nicknames',
            'delete'
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function applyScope($scope)
    {
        $scopeString = '';
        if (!is_null($scope)) {
            if (strpos($scope, '/') != 0) {
                $scopeString .= '/';
            }
            $scopeString .= $scope;
        }
        return $scopeString;
    }
}
