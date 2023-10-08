<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;

class WebhookHandlerService
{
    /**
     * Check specific task as done and removes "Done" button from chat message.
     *
     * @param int $taskId  ID of task
     * @param int $chatId  ID of chat
     *
     * @throws \Throwable
     */
    public function checkTaskAsDone(int $taskId, string $chatId)
    {
        $user = User::where('telegram_user_id', $chatId)->firstOrFail();

        $taskService = new TaskService();
        $taskService->delete(
            Task::withTrashed()
                ->where('user_id', $user->id)
                ->where('id', $taskId)
                ->firstOrFail()
        );
    }
}
