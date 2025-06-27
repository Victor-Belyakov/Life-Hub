<?php


namespace console\controllers;

use console\services\RbacService;
use Yii;
use yii\base\Exception;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public function actionInit(): void
    {
        $service = new RbacService(Yii::$app->authManager);
        $service->initRoles();
        echo "RBAC обновлено.\n";
    }

    /**
     * Назначает пользователю роль администратора
     * @param int $userId
     * @throws \Exception
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
