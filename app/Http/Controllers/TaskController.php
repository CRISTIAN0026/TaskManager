<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;



class TaskController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $tasks = Task::with('user:id,name', 'comments.user', 'attachments.user')->latest()->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'users' => User::all(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $users = User::all();
        return Inertia::render('Tasks/Create', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Task::class);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required|string|max:255',
            'status' => 'required',
            'user_id' => 'required',
        ]);

        Task::create($validated);

        return redirect(route('tasks.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('comments.user');

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('updateStatus', $task);

        $validated = $request->validate([
            'status' => 'required',
        ]);
        $task->update($validated);

        if ($validated['status'] == 'Completado' || $validated['status'] == 'Bloqueado') {
            $task->markAsCompleted($validated['status']);
        }

        return redirect(route('tasks.index'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {

        Gate::authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'sometimes',
            'user_id' => 'sometimes',
        ]);
        $task->update($validated);

        if (isset($validated['status']) && ($validated['status'] == 'Completado' || $validated['status'] == 'Bloqueado')) {
            $task->markAsCompleted($validated['status']);
        }

        return redirect(route('tasks.index'));
    }

    /**
     * Generate a report of tasks completed within a specific time period.
     *
     * @param  Request  $request
     * @return Response
     */
    public function generateReport(Request $request)
    {
        $this->authorize('generateReport', Task::class);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $tasks = Task::whereBetween('created_at', [$validated['start_date'], $validated['end_date']])
            ->with('user:id,name')
            ->get();


        $report = $tasks->map(function ($task) {
            $completed_at = \Carbon\Carbon::parse($task->completed_at);
            $created_at = \Carbon\Carbon::parse($task->created_at);

            $duration = $task->completed_at
                ? $completed_at->diffForHumans($created_at, [
                    'parts' => 2,  
                    'short' => true, 
                ])
                : 'En ejecución';

            return [
                'task_name' => $task->title,
                'user' => $task->user->name,
                'status' => $task->status,
                'time' => $duration,
            ];
        });

        return response()->json($report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
