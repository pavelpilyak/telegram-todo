<?php

namespace App\Http\Webhooks;

use App\Services\AuthService;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;

class TelegramBotHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        $authService = new AuthService();
        // chat_id is the user's ID in this case
        $authService->createOrGetExistingUser($this->chat->chat_id);

        $this->chat->message('To open your To-Do list, press the "My To-Do" button')->send();
    }
}
