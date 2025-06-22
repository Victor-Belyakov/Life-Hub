<?php

namespace console\rbac\permissions\user;

use console\rbac\PermissionInterface;
use Exception;
use yii\rbac\ManagerInterface;

class ViewUserPermission implements PermissionInterface
{
    /**
     * @param ManagerInterface $auth
     * @return void
     * @throws Exception
     */
    public function create(ManagerInterface $auth): void
    {
        $perm = $auth->createPermission($this->getName());
        $perm->description = 'Просмотр пользователя';
        $auth->add($perm);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'viewUser';
    }
}
