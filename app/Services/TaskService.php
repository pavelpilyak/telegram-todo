<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskService
{
    /**
     * Gets and returns all user's tasks.
     *
     * @param bool $onlyTrashed If true, returns only deleted (a.k.a archived) tasks
     *
     * @return Task[] User's tasks
     */
    public function getAll(bool $onlyTrashed = false)
    {
        $tasks = Task::where('user_id', auth()->user()->id)
            // minus to put nulls in first place
            ->orderByRaw(($onlyTrashed ? '-' : '') . 'notify_at asc')
            ->orderBy('deleted_at', 'desc');

        if ($onlyTrashed) {
            $tasks = $tasks->onlyTrashed();
        }

        return $tasks->get();
    }

    /**
     * Stores new task in database.
     *
     * @param array $data Task data
     */
    public function create(array $data): void
    {
        if (isset($data['notify_at'], $data['timezone']) && !empty($data['notify_at']) && !empty($data['timezone'])) {
            $date = Carbon::parse($data['notify_at'], $data['timezone']);
            $date->setTimezone(config('app.timezone'));

            $data['notify_at'] = $date->format('Y-m-d H:i:s');
        }

        auth()->user()->tasks()->create($data);
    }

    /**
     * Restores (makes deleted_at null) specific task.
     *
     * @param Task $task Task which should be restored
     */
    public function restore(Task $task): void
    {
        $task->restore();
    }

    /**
     * Archives (set deleted_at property) specific task.
     *
     * @param Task $task Task which should be archived
     */
    public function delete(Task $task): void
    {
        $task->delete();
    }
}
