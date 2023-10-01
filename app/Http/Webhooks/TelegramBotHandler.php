<?php

namespace App\Http\Webhooks;

class TelegramBotHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        $this->chat->html('hi')->send();
    }
}
