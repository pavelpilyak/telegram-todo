<?php

namespace App\Http\Webhooks;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class TelegramBotHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        $this->chat
            ->html('To open your To-Do list, press the "My To-Do" button')
            ->send();
    }
}
