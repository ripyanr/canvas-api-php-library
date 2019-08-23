<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiClient;
use Uncgits\CanvasApi\CanvasApiResult;

/**
 * https://canvas.instructure.com/doc/api/users.html
 */
class Users extends CanvasApiClient
{
    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function listUsersInAccount($account_id)
    {
        return new CanvasApiResult($this->paginate('accounts/' . $account_id . '/users', 'get'));
    }

    public function listActivityStream()
    {
        return new CanvasApiResult($this->paginate('users/self/activity_stream', 'get'));
    }

    public function activityStreamSummary()
    {
        return new CanvasApiResult($this->paginate('users/self/activity_stream/summary', 'get'));
    }

    public function listTodoItems()
    {
        return new CanvasApiResult($this->paginate('users/self/todo', 'get'));
    }

    public function listCountsForTodoItems()
    {
        return new CanvasApiResult($this->paginate('users/self/todo_item_count', 'get'));
    }

    public function listUpcomingAssignmentsAndCalendarEvents()
    {
        return new CanvasApiResult($this->paginate('users/self/upcoming_events', 'get'));
    }

    public function listMissingSubmissions($user_id = 'self')
    {
        return new CanvasApiResult($this->paginate('users/' . $user_id . '/missing_submissions', 'get'));
    }

    public function hideStreamItem($id)
    {
        return new CanvasApiResult($this->call('users/self/activity_stream/' . $id, 'delete'));
    }

    public function hideAllStreamItems()
    {
        return new CanvasApiResult($this->call('users/self/activity_stream', 'delete'));
    }

    public function uploadFile($user_id, $local_file_path)
    {
        // TODO: multi-step process to get AWS address and key - skip for now.
    }

    public function showUserDetails($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id, 'get'));
    }

    public function createUser($account_id)
    {
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/users', 'post'));
    }

    public function selfRegisterUser($account_id)
    {
        return new CanvasApiResult($this->call('accounts/' . $account_id . '/self_registration', 'post'));
    }

    public function getUserSettings($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id . '/settings', 'get'));
    }

    public function updateUserSettings($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id . '/settings', 'put'));
    }

    public function getCustomColors($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id . '/colors', 'get'));
    }

    public function getCustomColor($id = 'self', $asset_string)
    {
        return new CanvasApiResult($this->call('users/' . $id . '/colors/' . $asset_string, 'get'));
    }

    public function updateCustomColor($id = 'self', $asset_string)
    {
        return new CanvasApiResult($this->call('users/' . $id . '/colors/' . $asset_string, 'put'));
    }

    // NOTE - listed as BETA endpoint
    public function getDashboardPositions($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id . '/dashboard_positions', 'get'));
    }

    // NOTE - listed as BETA endpoint
    public function updateDashboardPositions($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id . '/dashboard_positions', 'put'));
    }

    public function editUser($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id, 'put'));
    }

    public function mergeUserIntoAnotherUser($id, $destination_user_id, $destination_account_id = null)
    {
        if (!is_null($destination_account_id)) {
            return new CanvasApiResult(
                $this->call('users/' . $id . '/merge_into/accounts/' . $destination_account_id .
                    '/users/' . $destination_user_id, 'put')
            );
        }
        return new CanvasApiResult($this->call('users/' . $id . '/merge_into/' . $destination_user_id, 'put'));
    }

    public function splitMergedUsersIntoSeparateUsers($id)
    {
        return new CanvasApiResult($this->call('users/' . $id . '/split', 'post'));
    }

    public function getPandataEventsJwtToken()
    {
        return new CanvasApiResult($this->call('users/self/pandata_events_token', 'post'));
    }

    public function getMostRecentlyGradedSubmissions($id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $id . '/graded_submissions', 'get'));
    }

    public function listAvaterOptions($user_id = 'self')
    {
        return new CanvasApiResult($this->call('users/' . $user_id . '/avatars', 'get'));
    }

    public function listUserPageViews($user_id = 'self')
    {
        return new CanvasApiResult($this->paginate('users/' . $user_id . '/page_views', 'get'));
    }

    public function storeCustomData($user_id = 'self', $scope = null)
    {
        return new CanvasApiResult($this->call('users/' . $user_id . '/custom_data' . $this->applyScope($scope), 'put'));
    }

    public function loadCustomData($user_id = 'self', $scope = null)
    {
        return new CanvasApiResult($this->call('users/' . $user_id . '/custom_data' . $this->applyScope($scope), 'get'));
    }

    public function deleteCustomData($user_id = 'self', $scope = null)
    {
        return new CanvasApiResult($this->call('users/' . $user_id . '/custom_data' . $this->applyScope($scope), 'delete'));
    }

    public function listCourseNicknames()
    {
        return new CanvasApiResult($this->paginate('users/self/course_nicknames', 'get'));
    }

    public function getCourseNickname($course_id)
    {
        return new CanvasApiResult($this->paginate('users/self/course_nicknames/' . $course_id, 'get'));
    }

    public function setCourseNickname($course_id)
    {
        return new CanvasApiResult($this->paginate('users/self/course_nicknames/' . $course_id, 'put'));
    }

    public function removeCourseNickname($course_id)
    {
        return new CanvasApiResult($this->paginate('users/self/course_nicknames/' . $course_id, 'delete'));
    }

    public function clearCourseNicknames()
    {
        return new CanvasApiResult($this->paginate('users/self/course_nicknames', 'delete'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function applyScope(string $scope)
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
