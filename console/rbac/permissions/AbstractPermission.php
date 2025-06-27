<?php

namespace console\rbac\permissions;
use console\rbac\PermissionInterface;
use Exception;
use yii\rbac\ManagerInterface;

abstract class AbstractPermission implements PermissionInterface
{
    /**
     * @param ManagerInterface $auth
     * @return void
     * @throws Exception
     */
    public function create(ManagerInterface $auth): void
    {
        $perm = $auth->createPermission(static::getName());
        $perm->description = static::getDescription();
        $auth->add($perm);
    }
}
