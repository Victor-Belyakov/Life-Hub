<?php

use console\rbac\permissions\user\UserCreatePermission;
use yii\helpers\Html;

?>
<p>
    <?php
    if (Yii::$app->user->can(UserCreatePermission::getName())) {
        echo Html::a('Зарегистрировать', ['/auth/signup', 'returnUrl' => Yii::$app->request->referrer], ['class' => 'btn btn-success text-light']);
    }
    ?>
</p>
