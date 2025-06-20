<?php

namespace frontend\controllers;

use common\models\LoginForm;
use frontend\models\form\user\SignupForm;
use UserService;
use Yii;
use yii\db\Exception;
use yii\web\Response;

class AuthBaseController extends BaseController
{
    /**
     * @return Response|string
     * @throws Exception
     */
    public function actionSignup(): Response|string
    {
        $form = new SignupForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $userService = new UserService();
            $user = $form->toUser();

            if ($userService->register($user)) {
                Yii::$app->session->setFlash('success', 'Регистрация прошла успешно.');
                return $this->goHome();
            }
        }

        return $this->render('signup', ['model' => $form]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin(): mixed
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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
