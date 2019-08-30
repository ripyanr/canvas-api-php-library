<?php

namespace Uncgits\CanvasApi\Clients;

use Uncgits\CanvasApi\CanvasApiResult;
use Uncgits\CanvasApi\Traits\HasApiAdapter;

/**
 * https://canvas.instructure.com/doc/api/users.html
 */
class Users implements CanvasApiClientInterface
{
    use HasApiAdapter;

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function listUsersInAccount($account_id)
    {
        return new CanvasApiResult($this->get('accounts/' . $account_id . '/users'));
    }

    public function listActivityStream()
    {
        return new CanvasApiResult($this->get('users/self/activity_stream'));
    }

    public function activityStreamSummary()
    {
        return new CanvasApiResult($this->get('users/self/activity_stream/summary'));
    }

    public function listTodoItems()
    {
        return new CanvasApiResult($this->get('users/self/todo'));
    }

    public function listCountsForTodoItems()
    {
        return new CanvasApiResult($this->get('users/self/todo_item_count'));
    }

    public function listUpcomingAssignmentsAndCalendarEvents()
    {
        return new CanvasApiResult($this->get('users/self/upcoming_events'));
    }

    public function listMissingSubmissions($user_id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/missing_submissions'));
    }

    public function hideStreamItem($id)
    {
        return new CanvasApiResult($this->delete('users/self/activity_stream/' . $id));
    }

    public function hideAllStreamItems()
    {
        return new CanvasApiResult($this->delete('users/self/activity_stream'));
    }

    public function uploadFile($user_id, $local_file_path)
    {
        // TODO: multi-step process to get AWS address and key - skip for now.
    }

    public function showUserDetails($id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $id));
    }

    public function createUser($account_id)
    {
        $this->setRequiredParameters(['pseudonym.unique_id']);
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/users'));
    }

    public function selfRegisterUser($account_id)
    {
        $this->setRequiredParameters(['user.name', 'user.terms_of_use', 'pseudonym.unique_id']);
        return new CanvasApiResult($this->post('accounts/' . $account_id . '/self_registration'));
    }

    public function getUserSettings($id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $id . '/settings'));
    }

    public function updateUserSettings($id = 'self')
    {
        return new CanvasApiResult($this->put('users/' . $id . '/settings'));
    }

    public function getCustomColors($id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $id . '/colors'));
    }

    public function getCustomColor($id = 'self', $asset_string)
    {
        return new CanvasApiResult($this->get('users/' . $id . '/colors/' . $asset_string));
    }

    public function updateCustomColor($id = 'self', $asset_string)
    {
        return new CanvasApiResult($this->put('users/' . $id . '/colors/' . $asset_string));
    }

    // NOTE - listed as BETA endpoint
    public function getDashboardPositions($id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $id . '/dashboard_positions'));
    }

    // NOTE - listed as BETA endpoint
    public function updateDashboardPositions($id = 'self')
    {
        return new CanvasApiResult($this->put('users/' . $id . '/dashboard_positions'));
    }

    public function editUser($id = 'self')
    {
        return new CanvasApiResult($this->put('users/' . $id));
    }

    public function mergeUserIntoAnotherUser($id, $destination_user_id, $destination_account_id = null)
    {
        if (!is_null($destination_account_id)) {
            return new CanvasApiResult(
                $this->put('users/' . $id . '/merge_into/accounts/' . $destination_account_id .
                    '/users/' . $destination_user_id)
            );
        }
        return new CanvasApiResult($this->put('users/' . $id . '/merge_into/' . $destination_user_id));
    }

    public function splitMergedUsersIntoSeparateUsers($id)
    {
        return new CanvasApiResult($this->post('users/' . $id . '/split'));
    }

    public function getPandataEventsJwtToken()
    {
        return new CanvasApiResult($this->post('users/self/pandata_events_token'));
    }

    public function getMostRecentlyGradedSubmissions($id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $id . '/graded_submissions'));
    }

    public function listAvatarOptions($user_id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/avatars'));
    }

    public function listUserPageViews($user_id = 'self')
    {
        return new CanvasApiResult($this->get('users/' . $user_id . '/page_views'));
    }

    public function storeCustomData($user_id = 'self', $scope = null)
    {
        $this->setRequiredParameters(['ns', 'data']);
        return new CanvasApiResult($this->put('users/' . $user_id . '/custom_data' . $this->applyScope($scope)));
    }

    public function loadCustomData($user_id = 'self', $scope = null)
    {
        $this->setRequiredParameters(['ns']);
        return new CanvasApiResult($this->get('users/' . $user_id . '/custom_data' . $this->applyScope($scope)));
    }

    public function deleteCustomData($user_id = 'self', $scope = null)
    {
        $this->setRequiredParameters(['ns']);
        return new CanvasApiResult($this->delete('users/' . $user_id . '/custom_data' . $this->applyScope($scope)));
    }

    public function listCourseNicknames()
    {
        return new CanvasApiResult($this->get('users/self/course_nicknames'));
    }

    public function getCourseNickname($course_id)
    {
        return new CanvasApiResult($this->get('users/self/course_nicknames/' . $course_id));
    }

    public function setCourseNickname($course_id)
    {
        $this->setRequiredParameters(['nickname']);
        return new CanvasApiResult($this->put('users/self/course_nicknames/' . $course_id));
    }

    public function removeCourseNickname($course_id)
    {
        return new CanvasApiResult($this->delete('users/self/course_nicknames/' . $course_id));
    }

    public function clearCourseNicknames()
    {
        return new CanvasApiResult($this->delete('users/self/course_nicknames'));
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
