<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TaskStatus::all();
        return view('tasks.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status_id' => 'required',
        ]);

        Task::create($validatedData);

        session()->flash('success', __('messages.task_created'));

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $statuses = TaskStatus::all();
        return view('tasks.edit', compact('task', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status_id' => 'required',
        ]);

        $task->update($validatedData);

        session()->flash('success', __('messages.task_updated'));

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Проверяем, может ли текущий пользователь удалять задачу
        if ($task->created_by_id != auth()->id()) {
            session()->flash('error', __('messages.task_delete_failed'));
            return redirect()->route('tasks.index');
        }

        $task->delete();

        session()->flash('success', __('messages.task_deleted'));

        return redirect()->route('tasks.index');
    }
}
