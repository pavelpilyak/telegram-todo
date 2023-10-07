<?php

namespace App\Service;

use App\Models\Task;
use DefStudio\Telegraph\Facades\Telegraph;

class WebhookHandlerService
{
    public function checkTaskAsDone(int $taskId, int $messageId)
    {
        Task::findOrFail($taskId)->delete();
        Telegraph::deleteKeyboard(messageId: $messageId)->send();
    }
}
