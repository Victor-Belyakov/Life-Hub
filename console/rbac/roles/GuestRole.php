<?php

namespace console\rbac\roles;

use console\rbac\RoleInterface;
use Exception;
use yii\rbac\ManagerInterface;

class GuestRole implements RoleInterface
{
    public const string ROLE_GUEST = 'guest';

    /**
     * @param ManagerInterface $auth
     * @return void
     * @throws Exception
     */
    public function create(ManagerInterface $auth): void
    {
        $guest = $auth->createRole('guest');
        $auth->add($guest);
    }

    public function getName(): string
    {
        return 'guest';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Гость';
    }

    public function getChildrenRoles(): array
    {
        return [];
    }

    public function getPermissions(): array
    {
        return [];
    }
}
