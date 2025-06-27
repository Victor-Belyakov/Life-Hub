<?php

namespace console\rbac\roles;

use console\rbac\permissions\task\TaskIndexPermission;
use console\rbac\permissions\user\UserCreatePermission;
use console\rbac\permissions\user\UserIndexPermission;
use console\rbac\permissions\user\UserUpdatePermission;
use console\rbac\permissions\user\UserViewPermission;
use console\rbac\RoleInterface;
use Exception;
use yii\rbac\ManagerInterface;

class AdminRole implements RoleInterface
{
    public const string ROLE_ADMIN = 'admin';

    /**
     * @param ManagerInterface $auth
     * @return void
     * @throws Exception
     */
    public function create(ManagerInterface $auth): void
    {
        $admin = $auth->createRole('admin');
        $auth->add($admin);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'admin';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Администратор';
    }

    /**
     * @return string[]
     */
    public function getChildrenRoles(): array
    {
        return ['user'];
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return [
            UserCreatePermission::class,
            UserUpdatePermission::class,
            UserIndexPermission::class,
            UserViewPermission::class,
            TaskIndexPermission::class,
        ];
    }
}
