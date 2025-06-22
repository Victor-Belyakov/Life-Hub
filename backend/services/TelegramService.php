<?php
namespace backend\services;

use Dotenv\Dotenv;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class TelegramService
{
    private string $botToken;
    private string $chatId;

    public function __construct()
    {
        $this->botToken = $_ENV['TELEGRAM_TOKEN'];
        $this->chatId = $_ENV['TELEGRAM_CHAT_ID'];
    }

    /**
     * Отправить текстовое сообщение в Telegram
     * @param string $text
     * @return bool
     * @throws Exception
     */
    public function sendMessage(string $text): bool
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $client = new Client();

        $response = $client->post($url, [
            'chat_id' => $this->chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ])->send();

        return $response->isOk;
    }
}
