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
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => $this->service->getAll(),
            'timezone' => config('app.timezone'),
        ]);
    }

    /**
     * todo
     */
    public function archive()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => $this->service->getAll(true),
            'timezone' => config('app.timezone'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
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
     * Restores the specified resource in storage.
     */
    public function restore(Task $task)
    {
        $this->authorize('restore', $task);
        $this->service->restore($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->service->delete($task);
    }
}
