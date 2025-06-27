<?php
namespace console\services;

use console\rbac\roles\AdminRole;
use console\rbac\roles\GuestRole;
use console\rbac\roles\UserRole;
use yii\base\Exception;
use yii\rbac\ManagerInterface;

class RbacService
{
    private ManagerInterface $auth;

    public function __construct(ManagerInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function initRoles(): void
    {
        $roles = [
            new GuestRole(),
            new UserRole(),
            new AdminRole(),
        ];

        foreach ($roles as $role) {
            $this->createOrUpdateRole($role);
            $this->assignPermissionsToRole($role);
        }
    }

    /**
     * @param $role
     * @return void
     * @throws \Exception
     */
    private function createOrUpdateRole($role): void
    {
        $roleObj = $this->auth->getRole($role->getName());
        if ($roleObj) {
            $roleObj->description = $role->getDescription();
            $this->auth->update($role->getName(), $roleObj);
        } else {
            $roleObj = $this->auth->createRole($role->getName());
            $roleObj->description = $role->getDescription();
            $this->auth->add($roleObj);
        }
    }

    /**
     * @param $role
     * @return void
     * @throws Exception
     */
    private function assignPermissionsToRole($role): void
    {
        $roleObj = $this->auth->getRole($role->getName());
        $existingChildren = $this->auth->getChildren($roleObj->name);

        foreach ($role->getPermissions() as $permissionClass) {
            $permissionName = $permissionClass::getName();

            $permission = $this->auth->getPermission($permissionName);

            $description = method_exists($permissionClass, 'getDescription')
                ? $permissionClass::getDescription()
                : "Описание для $permissionName";

            if (!$permission) {
                $permission = $this->auth->createPermission($permissionName);
                $permission->description = $description;
                $this->auth->add($permission);
            } else {
                $permission->description = $description;
                $this->auth->update($permissionName, $permission);
            }

            if (!isset($existingChildren[$permissionName])) {
                $this->auth->addChild($roleObj, $permission);
            }
        }
    }
}
