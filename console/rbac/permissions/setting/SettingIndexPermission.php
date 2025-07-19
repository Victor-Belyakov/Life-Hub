<?php

namespace console\rbac\permissions\setting;

use console\rbac\permissions\AbstractPermission;

class SettingIndexPermission extends AbstractPermission
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'settingIndex';
    }

    public static function getDescription(): string
    {
        return 'Меню настроек';
    }
}