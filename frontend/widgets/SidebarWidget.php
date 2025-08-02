<?php

namespace app\widgets;

use console\rbac\permissions\record\RecordIndexPermission;
use console\rbac\permissions\setting\SettingIndexPermission;
use console\rbac\permissions\task\TaskIndexPermission;
use console\rbac\permissions\user\UserIndexPermission;
use yii\base\Widget;

class SidebarWidget extends Widget
{
    public function run()
    {
        $menuItems = [
            [
                'label' => 'Задачи',
                'url' => ['/task/index'],
                'icon' => 'bi-calendar-check-fill',
                'permission' => TaskIndexPermission::getName(),
            ],
            [
                'label' => 'Записи',
                'url' => ['/record/index'],
                'icon' => 'bi bi-book-half',
                'permission' => RecordIndexPermission::getName(),
            ],
            [
                'label' => 'Пользователи',
                'url' => ['/user/index'],
                'icon' => 'bi-people-fill',
                'permission' => UserIndexPermission::getName(),
            ],
            [
                'label' => 'Справочники',
                'url' => ['/reference/index'],
                'icon' => 'bi-folder-fill',
                'permission' => 'reference.view',
            ],
            [
                'label' => 'Настройки',
                'icon' => 'bi-gear-fill',
                'permission' => SettingIndexPermission::getName(),
                'items' => [
                    [
                        'label' => 'Разделы для записей',
                        'url' => ['/section/index']
                    ],
                    [
                        'label' => 'Упражнения',
                        'url' => ['/exercise/index']
                    ]
                ],
            ],
        ];

        return $this->render('sidebar', [
            'menuItems' => $menuItems,
        ]);
    }
}
