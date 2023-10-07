<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;

class NotificationService
{
    public function notifyAboutTaskExpiration()
    {
        $notifiableTasks = Task::with('user')
            ->where('notify_at', Carbon::now()->format('Y-m-d H:i:00'))
            ->get();

        foreach ($notifiableTasks as $task) {
            TelegraphChat::where('chat_id', $task->user->telegram_user_id)
                ->first()
                ?->message("📅: $task->description")
                ?->keyboard(Keyboard::make()->buttons([
                    Button::make('✅ Done')
                        ->action('checkAsDone')
                        ->param('id', (string)($task->id)),
                ]))
                ?->send();
        }
    }
}
