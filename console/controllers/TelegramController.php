<?php

namespace console\controllers;

use common\models\Telegram;
use JsonException;
use Yii;
use yii\db\Exception;
use yii\web\Controller;

class TelegramController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @throws Exception
     * @throws JsonException
     */
    public function actionWebhook(): string
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true, 512, JSON_THROW_ON_ERROR);

        if (!empty($data['message'])) {
            $chatId = $data['message']['chat']['id'];
            $telegramUserId = $data['message']['from']['id'];

            $telegram = Telegram::find()->where(['telegram_user_id' => $telegramUserId])->one();

            if (!$telegram) {
                return 'Telegram not found';
            }

            if ($telegram->chat_id != $chatId) {
                $telegram->chat_id = $chatId;
                $telegram->save(false);
            }
        }

        return 'ok';
    }
}
