<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use DefStudio\Telegraph\Facades\Telegraph;

class WebhookHandlerService
{
    /**
     * Check specific task as done and removes "Done" button from chat message.
     *
     * @param int $taskId    ID of task
     * @param int $chatId    ID of chat
     * @param int $messageId ID of chat message
     *
     * @throws \Throwable
     */
    public function checkTaskAsDone(int $taskId, string $userId, int $messageId)
    {
        $user = User::where('telegram_user_id', $userId)->firstOrFail();

        $taskService = new TaskService();
        $taskService->delete(
            Task::withTrashed()
                ->where('user_id', $user->id)
                ->where('id', $taskId)
                ->firstOrFail()
        );

        Telegraph::deleteKeyboard(messageId: $messageId)->send();
    }
}
