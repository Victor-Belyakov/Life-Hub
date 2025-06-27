<?php

namespace console\rbac\permissions\user;

use console\rbac\PermissionInterface;
use console\rbac\permissions\AbstractPermission;
use Exception;
use yii\rbac\ManagerInterface;

class UserViewPermission extends AbstractPermission
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'userView';
    }

    public static function getDescription(): string
    {
        return 'Просмотр пользователя';
    }
}
