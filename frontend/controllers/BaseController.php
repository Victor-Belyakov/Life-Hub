<?php


use yii\filters\AccessControl;
use yii\web\Controller as BaseController;
use yii\web\ErrorAction;

class Controller extends BaseController
{
    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['site/login']);
                },
                'except' => ['login', 'signup'],
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
