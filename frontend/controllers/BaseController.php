<?php


namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;

class BaseController extends Controller
{
    /**
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            $auth = Yii::$app->authManager;
            $roles = $auth->getRolesByUser(Yii::$app->user->id);

            if (empty($roles) && !in_array($action->id, ['no-role', 'logout']) ) {
                return $this->redirect(['auth/no-role']);
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    return Yii::$app->response->redirect(['auth/login']);
                },
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
