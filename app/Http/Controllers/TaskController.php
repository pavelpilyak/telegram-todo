<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected TaskService $service;

    public function __construct()
    {
        $this->service = new TaskService();
    }

    /**
     * Render page with all user's tasks.
     */
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => $this->service->getAll(),
            'timezone' => config('app.timezone'),
        ]);
    }

    /**
     * Render page with all user's archived (done) tasks.
     */
    public function archive()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => $this->service->getAll(true),
            'timezone' => config('app.timezone'),
        ]);
    }

    /**
     * Store a newly created task in database.
     */
    public function store(Request $request)
    {
        $this->service->create($request->validate([
            'description' => 'required|string',
            'notify_at' => 'nullable|date_format:Y-m-d H:i',
            'timezone' => 'nullable|timezone',
        ]));
    }

    /**
     * Restore the specified task in database.
     */
    public function restore(Task $task)
    {
        $this->authorize('restore', $task);
        $this->service->restore($task);
    }

    /**
     * Check the specified task as done in database.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->service->delete($task);
    }
}
