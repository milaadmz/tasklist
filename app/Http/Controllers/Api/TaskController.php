<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResources;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
//show all tasks that shared with Auth user with polymorphic relationship to resource
        $sharedAll = Auth::user()->share();
        return TaskResources::collection(Task::whereIn('id', $sharedAll->pluck('task_id'))->get());
    }

    public function store(TaskRequest $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();

        $this->addShareable($task);

        return new TaskResources($task);
    }

//        show the task if it shared with Auth user
    public function show(Task $task)
    {
        if (Auth::user()->share()->where('task_id', $task->id)->first()) {
            return new TaskResources($task);
        } else {
            return response()->json([
                'message' => 'you are not allowed to see this task'
            ], 401);
        }
    }

//        update task if the user is the owner of the task in polymorphic relationship
    public function update(TaskRequest $request, Task $task)
    {
        if (Auth::user()->share()->where('task_id', $task->id)->first()) {
            $task->title = $request->title;
            $task->description = $request->description;
            $task->save();
            return new TaskResources($task);
        } else {
            return response()->json([
                'message' => 'you are not the owner of this task'
            ], 401);
        }
    }

//        delete the task if the user is the owner of the task in polymorphic relationship
    public function destroy(Task $task)
    {
        if (Auth::user()->share()->where('task_id', $task->id)->first()) {
            $task->delete();
            return response()->json([
                'message' => 'task deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'message' => 'you are not the owner of this task'
            ], 401);
        }
    }
    public function addShareable($task)
    {
        return Auth::user()->share()->create([
            'shareable_id' => Auth::user()->id,
            'shareable_type' => 'App\Models\User',
            'task_id' => $task->id,
        ]);
    }
}
