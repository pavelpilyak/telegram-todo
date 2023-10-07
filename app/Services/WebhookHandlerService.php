<?php

namespace App\Services;

use App\Models\Task;
use DefStudio\Telegraph\Facades\Telegraph;

class WebhookHandlerService
{
    /**
     * Check specific task as done and removes "Done" button from chat message.
     *
     * @param int $taskId    ID of task
     * @param int $messageId ID of chat message
     *
     * @throws \Throwable
     */
    public function checkTaskAsDone(int $taskId, int $messageId)
    {
        $taskService = new TaskService();
        $taskService->delete(Task::findOrFail($taskId));
        Telegraph::deleteKeyboard(messageId: $messageId)->send();
    }
}
