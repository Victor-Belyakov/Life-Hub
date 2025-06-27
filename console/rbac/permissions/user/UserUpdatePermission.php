<?php

namespace console\rbac\permissions\user;

use console\rbac\PermissionInterface;
use console\rbac\permissions\AbstractPermission;
use Exception;
use yii\rbac\ManagerInterface;

class UserUpdatePermission extends AbstractPermission
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'userUpdate';
    }

    public static function getDescription(): string
    {
        return 'Редактирование пользователя';
    }
}
