<?php
namespace common\services;

use common\models\User;
use Exception;
use Yii;

class UserService
{
    /**
     * @throws \yii\db\Exception
     */
    public function register(User $user): bool
    {
        return $user->save();
    }

    /**
     * @param int $userId
     * @param string|null $roleName
     * @return void
     * @throws Exception
     * @throws Exception
     */
    public static function assignRole(int $userId, ?string $roleName): void
    {
        if (empty($roleName)) {
            return;
        }

        $auth = Yii::$app->authManager;

        $auth->revokeAll($userId);

        $role = $auth->getRole($roleName);
        if ($role) {
            $auth->assign($role, $userId);
        }
    }
}
