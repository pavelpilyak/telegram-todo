<?php

namespace App\Http\Webhooks;

use App\Service\WebhookHandlerService;
use App\Services\AuthService;
use Illuminate\Support\Stringable;

class TelegramBotHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    protected string $defaultMessage = 'To open your To-Do list, press the "My To-Do" button';
    protected WebhookHandlerService $service;

    public function __construct()
    {
        $this->service = new WebhookHandlerService();
    }

    public function start(): void
    {
        $authService = new AuthService();
        // chat_id is the user's ID in this case, because thats how Telegraph package works
        $authService->createOrGetExistingUser($this->chat->chat_id);

        $this->chat->message($this->defaultMessage)->send();
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $this->chat->message($this->defaultMessage)->send();
    }

    public function checkAsDone()
    {
        $id = $this->data->get('id');
        $messageId = $this->callbackQuery->message()->id();

        $this->service->checkTaskAsDone((int)$id, $messageId);
    }
}
