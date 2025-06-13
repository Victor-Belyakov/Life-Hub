<?php

use common\models\User;

class UserService
{
    /**
     * @throws \yii\db\Exception
     */
    public function register(User $user): bool
    {
        return $user->save();
    }
}
