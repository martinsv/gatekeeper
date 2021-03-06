<?php

namespace Psecio\Gatekeeper;

class GroupModel extends \Psecio\Gatekeeper\Model\Mysql
{
    /**
     * Database table name
     * @var string
     */
    protected $tableName = 'groups';

    /**
     * Model properties
     * @var array
     */
    protected $properties = array(
        'description' => array(
            'description' => 'Group Description',
            'column' => 'description',
            'type' => 'varchar'
        ),
        'id' => array(
            'description' => 'Group ID',
            'column' => 'id',
            'type' => 'integer'
        ),
        'name' => array(
            'description' => 'Group name',
            'column' => 'name',
            'type' => 'varchar'
        ),
        'created' => array(
            'description' => 'Date Created',
            'column' => 'created',
            'type' => 'datetime'
        ),
        'updated' => array(
            'description' => 'Date Updated',
            'column' => 'updated',
            'type' => 'datetime'
        ),
        'users' => array(
            'description' => 'Users belonging to this group',
            'type' => 'relation',
            'relation' => array(
                'model' => '\\Psecio\\Gatekeeper\\UserCollection',
                'method' => 'findByGroupId',
                'local' => 'id'
            )
        ),
        'permissions' => array(
            'description' => 'Permissions belonging to this group',
            'type' => 'relation',
            'relation' => array(
                'model' => '\\Psecio\\Gatekeeper\\PermissionCollection',
                'method' => 'findByGroupId',
                'local' => 'id'
            )
        )
    );

    /**
     * Add a user to the group
     *
     * @param integer|UserModel $user Either a user ID or a UserModel instance
     */
    public function addUser($user)
    {
        if ($this->id === null) {
            return false;
        }
        if ($user instanceof UserModel) {
            $user = $user->id;
        }
        $data = array(
            'group_id' => $this->id,
            'user_id' => $user
        );
        $groupUser = new UserGroupModel($this->getDb(), $data);
        return $groupUser->save();
    }

    /**
     * Add a permission relation for the group
     *
     * @param integer|PermissionModel $permission Either a permission ID or PermissionModel
     */
    public function addPermission($permission)
    {
        if ($this->id === null) {
            return false;
        }
        if ($permission instanceof PermissionModel)
        {
            $permission = $permission->id;
        }
        $data = array(
            'permission_id' => $permission,
            'group_id' => $this->id
        );
        $groupPerm = new GroupPermissionModel($this->getDb(), $data);
        return $groupPerm->save();
    }

    /**
     * Check if the user is in the current group
     *
     * @param integer $userId User ID
     * @return boolean Found/not found in group
     */
    public function inGroup($userId)
    {
        $userGroup = new UserGroupModel($this->getDb());
        $result = $userGroup->find(array(
            'group_id' => $this->id,
            'user_id' => $userId
        ));
        return ($userGroup->id !== null) ? true : false;
    }
}