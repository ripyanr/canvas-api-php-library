<?php

namespace Uncgits\CanvasApi\Clients;

/**
 * https://canvas.instructure.com/doc/api/files.html
 */
class Files implements CanvasApiClientInterface
{
    public function getQuotaInformation($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/files/quota',
            'get'
        ];
    }

    // aliases
    public function getQuotaInformationForCourse($course_id)
    {
        return $this->getQuotaInformation('courses', $course_id);
    }
    public function getQuotaInformationForGroup($group_id)
    {
        return $this->getQuotaInformation('groups', $group_id);
    }
    public function getQuotaInformationForUser($user_id)
    {
        return $this->getQuotaInformation('users', $user_id);
    }

    public function listFiles($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/files',
            'get'
        ];
    }

    // aliases
    public function listFilesForCourse($course_id)
    {
        return $this->listFiles('courses', $course_id);
    }
    public function listFilesForUser($user_id)
    {
        return $this->listFiles('users', $user_id);
    }
    public function listFilesForGroup($group_id)
    {
        return $this->listFiles('groups', $group_id);
    }
    public function listFilesInFolder($folder_id)
    {
        return $this->listFiles('folders', $folder_id);
    }

    public function getPublicInlinePreviewUrl($id)
    {
        return [
            'files/' . $id . '/public_url',
            'get'
        ];
    }

    public function getFile($id, $entity_type = null, $entity_id = null)
    {
        if (!is_null($entity_type) && !is_null($entity_id)) {
            return [
                $entity_type . '/' . $entity_type . '/files/' . $id,
                'get'
            ];
        }

        return [
            'files/' . $id,
            'get'
        ];
    }

    public function updateFile($id)
    {
        return [
            'files/' . $id,
            'put'
        ];
    }

    public function deleteFile($id)
    {
        return [
            'files/' . $id,
            'delete'
        ];
    }

    public function listFolders($id)
    {
        return [
            'folders/' . $id,
            'get'
        ];
    }

    public function listAllFolders($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/folders',
            'get'
        ];
    }

    // aliases
    public function listAllFoldersForCourse($course_id)
    {
        return $this->listAllFolders('courses', $course_id);
    }
    public function listAllFoldersForUser($user_id)
    {
        return $this->listAllFolders('users', $user_id);
    }
    public function listAllFoldersForGroup($group_id)
    {
        return $this->listAllFolders('groups', $group_id);
    }

    public function resolvePath($entity_type, $entity_id, $full_path = null)
    {
        $path = '';
        if (!is_null($full_path)) {
            $path = $full_path;
            if (substr($path, 0, 1) !== '/') {
                $path = '/' . $path;
            }
        }

        return [
            $entity_type . '/' . $entity_id . '/folders/by_path' . $path,
            'get'
        ];
    }

    public function getFolder($id, $entity_type = null, $entity_id = null)
    {
        if (!is_null($entity_type) && !is_null($entity_id)) {
            return [
                $entity_type . '/' . $entity_id . '/folders/' . $id,
                'get'
            ];
        }

        return [
            'folders/' . $id,
            'get'
        ];
    }

    // aliases
    // TODO: this

    public function updateFolder($id)
    {
        return [
            'folders/' . $id,
            'put'
        ];
    }

    public function createFolder($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/folders',
            'post'
        ];
    }

    // aliases
    public function createFolderInCourse($course_id)
    {
        return $this->createFolder('courses', $course_id);
    }
    public function createFolderInUser($user_id)
    {
        return $this->createFolder('users', $user_id);
    }
    public function createFolderInGroup($group_id)
    {
        return $this->createFolder('groups', $group_id);
    }
    public function createFolderInFolder($folder_id)
    {
        return $this->createFolder('folders', $folder_id);
    }

    public function deleteFolder($id)
    {
        return [
            'folders/' . $id,
            'delete'
        ];
    }

    public function uploadFile($folder_id)
    {
        return [
            'folders/' . $folder_id . '/files',
            'post',
            ['name', 'size', 'content_type']
        ];
    }

    public function uploadFileToUploadUrl($url)
    {
        return [
            $url,
            'post',
            [],
            true
        ];
    }

    public function copyFile($dest_folder_id)
    {
        return [
            'folders/' . $dest_folder_id . '/copy_file',
            'post'
        ];
    }

    public function copyFolder($dest_folder_id)
    {
        return [
            'folders/' . $dest_folder_id . '/copy_folder',
            'post'
        ];
    }

    public function getUploadedMediaFolderForUser($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/folders/media',
            'get'
        ];
    }

    // aliases
    public function getUploadedMediaFolderForUserInCourse($course_id)
    {
        return $this->getUploadedMediaFolderForUser('courses', $course_id);
    }
    public function getUploadedMediaFolderForUserInGroup($group_id)
    {
        return $this->getUploadedMediaFolderForUser('groups', $group_id);
    }

    public function setUsageRights($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/usage_rights',
            'put'
        ];
    }

    // aliases
    public function setUsageRightsInCourse($course_id)
    {
        return $this->setUsageRights('courses', $course_id);
    }
    public function setUsageRightsInGroup($group_id)
    {
        return $this->setUsageRights('groups', $group_id);
    }
    public function setUsageRightsForUser($user_id)
    {
        return $this->setUsageRights('users', $user_id);
    }

    public function removeUsageRights($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/usage_rights',
            'delete'
        ];
    }

    // aliases
    public function removeUsageRightsInCourse($course_id)
    {
        return $this->removeUsageRights('courses', $course_id);
    }
    public function removeUsageRightsInGroup($group_id)
    {
        return $this->removeUsageRights('groups', $group_id);
    }
    public function removeUsageRightsForUser($user_id)
    {
        return $this->removeUsageRights('users', $user_id);
    }

    public function listLicenses($entity_type, $entity_id)
    {
        return [
            $entity_type . '/' . $entity_id . '/content_licenses',
            'get'
        ];
    }

    // aliases
    public function listLicensesInCourse($course_id)
    {
        return $this->listLicenses('courses', $course_id);
    }
    public function listLicensesInGroup($group_id)
    {
        return $this->listLicenses('groups', $group_id);
    }
    public function listLicensesForUser($user_id)
    {
        return $this->listLicenses('users', $user_id);
    }
}
