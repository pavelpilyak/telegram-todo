<?php

namespace App\Http\Webhooks;

use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class TelegramBotHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        $this->chat
            ->html('hi')
            ->keyboard(
                Keyboard::make()->buttons([
                    Button::make('My To-Do')->loginUrl(route('login')),
                ])
            )
            ->send();
    }
}
