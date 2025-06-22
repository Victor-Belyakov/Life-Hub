<?php

namespace console\rbac\roles;

use console\rbac\permissions\user\ViewUserPermission;
use console\rbac\RoleInterface;
use Exception;
use yii\rbac\ManagerInterface;

class UserRole implements RoleInterface
{
    public const string ROLE_USER = 'user';

    /**
     * @param ManagerInterface $auth
     * @return void
     * @throws Exception
     */
    public function create(ManagerInterface $auth): void
    {
        $user = $auth->createRole('user');
        $auth->add($user);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'user';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Пользователь';
    }

    /**
     * @return string[]
     */
    public function getChildrenRoles(): array
    {
        return ['guest'];
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return [
            ViewUserPermission::getName()
        ];
    }
}
