<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('Task.tasks')->with([
            'projects' => Project::all(),
        ]);
    }

    public function show($id)
    {
        $tasks = Task::where('project_id', $id)->get();

        $employees = Project::findOrFail($id)->employees;


        return view('Task.show_task')->with([
            'tasks' => $tasks,
            'projects' => Project::all(),
            'employees' => $employees,
            'project_id' => $id
        ]);
    }


    public function store(Request $request)
{

    $validated = $request->validate([
        'name' => 'required',
        'project_id' => 'required|exists:projects,id',
        'employee_ids' => 'required|array',
        'employee_ids.*' => 'exists:employees,id',
    ]);

    $task = Task::create([
        'name' => $validated['name'],
        'project_id' => $validated['project_id'],
        'status' => false,
    ]);

    $task->employees()->attach($validated['employee_ids']);

    return back()->with('success', 'Task created successfully.');
}

public function update(Request $request, Task $task, $id)
{
    Task::findOrFail($id)->update(['status'=> true]);
    return back();
    // $validated = $request->validate([
    //     'name' => 'required',
    //     'project_id' => 'required|exists:projects,id',
    //     'employee_ids' => 'required|array',
    //     'employee_ids.*' => 'exists:employees,id',
    // ]);

    // $task->update([
    //     'name' => $validated['name'],
    //     'project_id' => $validated['project_id'],
    //     'status' => $request->has('status'),
    // ]);

    // $task->employees()->sync($validated['employee_ids']);

    // return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
}

public function uncheck($id)
{
    Task::findOrFail($id)->update(['status'=> false]);
    return back();
}

public function destroy(Task $task)
{
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
}
}
