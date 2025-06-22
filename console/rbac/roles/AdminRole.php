<?php

namespace console\rbac\roles;

use console\rbac\permissions\user\CreateUserPermission;
use console\rbac\permissions\user\UpdateUserPermission;
use console\rbac\permissions\user\ViewUserPermission;
use console\rbac\RoleInterface;
use Exception;
use yii\rbac\ManagerInterface;

class AdminRole implements RoleInterface
{
    public const string ROLE_USER = 'admin';

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
            CreateUserPermission::getName(),
            UpdateUserPermission::getName(),
            ViewUserPermission::getName()
        ];
    }
}
