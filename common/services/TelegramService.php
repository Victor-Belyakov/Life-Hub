<?php

use yii\httpclient\Client;
use yii\httpclient\Exception;

class TelegramService
{
    /**
     * Отправить текстовое сообщение в Telegram
     *
     * @param string $text
     * @return bool
     * @throws Exception
     */
    public static function sendMessage(string $text): bool
    {
//        $token = $_ENV['TELEGRAM_TOKEN'];
        $token = '7790844686:AAHGN464hjXLFYXIT_rqvo6riu7EdSAS-cY';
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $client = new Client();

        $response = $client->post($url, [
//            'chat_id' => $_ENV['TELEGRAM_CHAT_ID'],
            'chat_id' => '-1002608930190',
            'text' => $text,
            'parse_mode' => 'HTML',
        ])->send();

        return $response->isOk;
    }
}