<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/groups.html
 */
class Groups implements CanvasApiClientInterface
{
    public function listGroups()
    {
        return [
            'users/self/groups',
            'get'
        ];
    }

    public function listGroupsAvailableInContext($context, $id)
    {
        return [
            $context . '/' . $id . '/groups',
            'get'
        ];
    }

    public function getSingleGroup($group_id)
    {
        return [
            'groups/' . $group_id,
            'get'
        ];
    }

    // alias
    public function getGroup($group_id)
    {
        return $this->getSingleGroup($group_id);
    }

    public function createGroup($group_category_id = null)
    {
        return [
            is_null($group_category_id) ? 'groups' : 'group_categories/' . $group_category_id . '/groups',
            'post'
        ];
    }

    public function editGroup($group_id)
    {
        return [
            'groups/' . $group_id,
            'put'
        ];
    }

    public function deleteGroup($group_id)
    {
        return [
            'groups/' . $group_id,
            'delete'
        ];
    }

    public function inviteOthersToGroup($group_id)
    {
        return [
            'groups/' . $group_id . '/invite',
            'post',
            ['invitees']
        ];
    }

    public function listGroupsUsers($group_id)
    {
        return [
            'groups/' . $group_id . '/users',
            'get'
        ];
    }

    public function uploadFile($group_id)
    {
        // TODO: multi-step process to get AWS address and key - skip for now.
    }

    public function previewProcessedHtml($group_id)
    {
        return [
            'groups/' . $group_id . '/preview_html',
            'post'
        ];
    }

    public function groupActivityStream($group_id)
    {
        return [
            'groups/' . $group_id . '/activity_stream',
            'get'
        ];
    }

    public function groupActivityStreamSummary($group_id)
    {
        return [
            'groups/' . $group_id . '/activity_stream/summary',
            'get'
        ];
    }

    public function permissions($group_id)
    {
        return [
            'groups/' . $group_id . '/permissions',
            'get'
        ];
    }

    public function listGroupMemberships($group_id)
    {
        return [
            'groups/' . $group_id . '/memberships',
            'get'
        ];
    }

    public function getSingleGroupMembership($group_id, $context, $id)
    {
        return [
            'groups/' . $group_id . '/' . $context . '/' . $id,
            'get'
        ];
    }

    // alias
    public function getMembership($group_id, $context, $id)
    {
        return $this->getSingleGroupMembership($group_id, $context, $id);
    }

    public function createMembership($group_id)
    {
        return [
            'groups/' . $group_id . '/memberships',
            'post'
        ];
    }

    public function updateMembership($group_id, $context, $id)
    {
        return [
            'groups/' . $group_id . '/' . $context . '/' . $id,
            'put'
        ];
    }

    public function leaveGroup($group_id, $context, $id)
    {
        return [
            'groups/' . $group_id . '/' . $context . '/' . $id,
            'delete'
        ];
    }
}
