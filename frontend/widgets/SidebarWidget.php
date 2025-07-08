<?php

namespace app\widgets;

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
                'icon' => 'bi-people-fill',
                'permission' => UserIndexPermission::getName(),
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
                'permission' => UserIndexPermission::getName(),
                'items' => [
                    [
                        'label' => 'Разделы для записей',
                        'url' => ['/section/index'],
                        'permission' => UserIndexPermission::getName(),
                    ]
                ],
            ],
        ];

        return $this->render('sidebar', [
            'menuItems' => $menuItems,
        ]);
    }
}
