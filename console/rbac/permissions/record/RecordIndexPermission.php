<?php

namespace console\rbac\permissions\record;

use console\rbac\permissions\AbstractPermission;

class RecordIndexPermission extends AbstractPermission
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'recordIndex';
    }

    public static function getDescription(): string
    {
        return 'Список записей';
    }
}