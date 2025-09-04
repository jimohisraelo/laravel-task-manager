<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:Pending,Completed',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required',
        'status' => 'required|in:Pending,Completed',
    ]);

    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect()->route('tasks.index')
                     ->with('success', 'Task updated successfully!');
}

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
