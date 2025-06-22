<?php

namespace frontend\controllers;

use backend\services\TelegramService;
use common\models\LoginForm;
use frontend\models\form\user\SignupForm;
use frontend\services\UserService;
use Yii;
use yii\db\Exception;
use yii\web\Response;

class AuthController extends BaseController
{
    /**
     * @return Response|string
     * @throws Exception
     */
    public function actionSignup(): Response|string
    {
        $form = new SignupForm();
        $returnUrl = Yii::$app->request->post('returnUrl', Yii::$app->homeUrl);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $userService = new UserService();
            $user = $form->toUser();

            if ($userService->register($user)) {
                return $this->redirect($returnUrl);
            }
        }

        return $this->render('signup', ['model' => $form]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     * @throws \yii\httpclient\Exception
     */
    public function actionLogin(): mixed
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $telegramService = new TelegramService();
            $telegramService->sendMessage('Пользователь: ' . Yii::$app->user->identity->email . ' авторизовался');
            return $this->redirect(['site/index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
