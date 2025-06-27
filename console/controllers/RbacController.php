<?php


namespace console\controllers;

use console\rbac\roles\AdminRole;
use console\rbac\roles\GuestRole;
use console\rbac\roles\UserRole;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionInit(): void
    {
        $auth = Yii::$app->authManager;

        $roles = [
            new GuestRole(),
            new UserRole(),
            new AdminRole(),
        ];

        foreach ($roles as $role) {
            $roleObj = $auth->getRole($role->getName());
            if ($roleObj) {
                $roleObj->description = $role->getDescription();
                $auth->update($role->getName(), $roleObj);
            } else {
                $roleObj = $auth->createRole($role->getName());
                $roleObj->description = $role->getDescription();
                $auth->add($roleObj);
            }

            foreach ($role->getPermissions() as $permissionName) {
                $permission = $auth->getPermission($permissionName);
                if ($permission) {
                    $permission->description = "Описание для $permissionName";
                    $auth->update($permissionName, $permission);
                } else {
                    $permission = $auth->createPermission($permissionName);
                    $permission->description = "Описание для $permissionName";
                    $auth->add($permission);
                }
                $children = $auth->getChildren($roleObj->name);
                if (!isset($children[$permissionName])) {
                    $auth->addChild($roleObj, $permission);
                }
            }
        }

        echo "RBAC обновлено.\n";
    }

    /**
     * Назначает пользователю роль администратора
     * @param int $userId
     */
    public function actionAssignAdmin(int $userId): void
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        if (!$role) {
            echo "Роль admin не найдена.\n";
            return;
        }

        $auth->assign($role, $userId);
        echo "Роль admin назначена пользователю с ID $userId.\n";
    }
}
