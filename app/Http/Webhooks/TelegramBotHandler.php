<?php

namespace App\Http\Webhooks;

use App\Services\AuthService;
use App\Services\WebhookHandlerService;
use Illuminate\Support\Stringable;

class TelegramBotHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    /**
     * Default message for start command on unknown messages.
     */
    protected string $defaultMessage = 'To open your To-Do list, press the "My To-Do" button';

    /**
     * Handler's service.
     */
    protected WebhookHandlerService $service;

    public function __construct()
    {
        $this->service = new WebhookHandlerService();
    }

    /**
     * Logic for chat's /start command.
     */
    public function start(): void
    {
        $authService = new AuthService();
        // chat_id is the user's ID in this case, because thats how Telegraph package works
        $authService->createOrGetExistingUser($this->chat->chat_id);

        $this->chat->message($this->defaultMessage)->send();
    }

    /**
     * Logic for any chat message.
     */
    protected function handleChatMessage(Stringable $text): void
    {
        $this->chat->message($this->defaultMessage)->send();
    }

    /**
     * Method which is called than user clicks on 'Done' button under notification message.
     */
    public function checkAsDone(): void
    {
        $id = $this->data->get('id');
        $chatId = $this->chat->chat_id;
        $messageId = $this->callbackQuery->message()->id();

        $this->service->checkTaskAsDone((int)$id, $chatId, $messageId);
    }
}
