<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public function getAll(bool $onlyTrashed = false)
    {
        $tasks = Task::where('user_id', auth()->user()->id)->orderBy('notify_at');

        if ($onlyTrashed) {
            $tasks = $tasks->onlyTrashed();
        }

        return $tasks->get();
    }

    public function create(array $data)
    {
        if (isset($data['notify_at'], $data['timezone']) && !empty($data['notify_at']) && !empty($data['timezone'])) {
            $date = Carbon::parse($data['notify_at'], $data['timezone']);
            $date->setTimezone(config('app.timezone'));

            $data['notify_at'] = $date->format('Y-m-d H:i:s');
        }

        auth()->user()->tasks()->create($data);
    }

    public function restore(Task $task)
    {
        $task->restore();
    }

    public function delete(Task $task)
    {
        $task->delete();
    }
}
