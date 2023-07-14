<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $taskStatuses = TaskStatus::all();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        TaskStatus::create($request->all());

        return redirect()->route('task_statuses.index')
            ->with('success', 'Статус успешно добавлен.');
    }

    /**
     * Display the specified resource.
     */
//    public function show(string $id)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',    }
        ]);
        $taskStatus->update($request->all());
        return redirect()->route('task_statuses.index')    public function destroy(string $id)
            ->with('success', 'Статус успешно обновлен.');    {
    }
    public function destroy(TaskStatus $taskStatus)
    {
        if ($taskStatus->tasks(->count() > 0) {
            return redirect()->route(('task_statues.index'))
                ->with('error', 'Статус связан с задачей и не может быть удален.');
        }

        $taskStatus->delete();

        return redirect()->route('task_statues.index')
            ->with('success', 'Статус успешно удален.');
    }
}
