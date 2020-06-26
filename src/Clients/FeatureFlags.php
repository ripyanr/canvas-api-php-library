<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/feature_flags.html
 */
class FeatureFlags implements CanvasApiClientInterface
{
    public function listCourseFeatures($course_id)
    {
        return [
            'courses/' . $course_id . '/features',
            'get'
        ];
    }

    public function listAccountFeatures($account_id)
    {
        return [
            'accounts/' . $account_id . '/features',
            'get'
        ];
    }

    public function listUserFeatures($user_id)
    {
        return [
            'users/' . $user_id . '/features',
            'get'
        ];
    }

    public function listCourseEnabledFeatures($course_id)
    {
        return [
            'courses/' . $course_id . '/features/enabled',
            'get'
        ];
    }

    public function listAccountEnabledFeatures($account_id)
    {
        return [
            'accounts/' . $account_id . '/features/enabled',
            'get'
        ];
    }

    public function listUserEnabledFeatures($user_id)
    {
        return [
            'users/' . $user_id . '/features/enabled',
            'get'
        ];
    }

    public function getCourseFeatureFlag($course_id, $feature)
    {
        return [
            'courses/' . $course_id . '/features/flags/' . $feature,
            'get'
        ];
    }

    public function getAccountFeatureFlag($account_id, $feature)
    {
        return [
            'accounts/' . $account_id . '/features/flags/' . $feature,
            'get'
        ];
    }

    public function getUserFeatureFlag($user_id, $feature)
    {
        return [
            'users/' . $user_id . '/features/flags/' . $feature,
            'get'
        ];
    }

    public function setCourseFeatureFlag($course_id, $feature)
    {
        return [
            'courses/' . $course_id . '/features/flags/' . $feature,
            'put'
        ];
    }

    public function setAccountFeatureFlag($account_id, $feature)
    {
        return [
            'accounts/' . $account_id . '/features/flags/' . $feature,
            'put'
        ];
    }

    public function setUserFeatureFlag($user_id, $feature)
    {
        return [
            'users/' . $user_id . '/features/flags/' . $feature,
            'put'
        ];
    }

    public function removeCourseFeatureFlag($course_id, $feature)
    {
        return [
            'courses/' . $course_id . '/features/flags/' . $feature,
            'delete'
        ];
    }

    public function removeAccountFeatureFlag($account_id, $feature)
    {
        return [
            'accounts/' . $account_id . '/features/flags/' . $feature,
            'delete'
        ];
    }

    public function removeUserFeatureFlag($user_id, $feature)
    {
        return [
            'users/' . $user_id . '/features/flags/' . $feature,
            'delete'
        ];
    }
}
