<?php

namespace console\rbac;

use yii\rbac\ManagerInterface;

interface PermissionInterface
{
    /**
     * @param ManagerInterface $auth
     * @return void
     */
    public function create(ManagerInterface $auth): void;

    /**
     * @return string
     */
    public static function getName(): string;

    /**
     * @return string
     */
    public static function getDescription(): string;
}
