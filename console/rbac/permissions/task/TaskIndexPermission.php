<?php

namespace console\rbac\permissions\task;

use console\rbac\permissions\AbstractPermission;

class TaskIndexPermission extends AbstractPermission
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'taskIndex';
    }

    public static function getDescription(): string
    {
        return 'Список задач';
    }
}
