<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResources;
use App\Http\Resources\UserResources;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
//        if role is admin return all users
    public function users()
    {
        if (Gate::allows('isAdmin', Auth::user())) {
            return UserResources::collection(User::all());
        } else {
            return response()->json([
                'message' => 'you are not admin'
            ], 401);
        }
    }

    //        if role is admin return all tasks
    public function tasks()
    {
        if (Gate::allows('isAdmin', Auth::user())) {
            return TaskResources::collection(Task::all());
        } else {
            return response()->json([
                'message' => 'you are not admin'
            ], 401);
        }
    }

    //        if role is admin share task to admin
    public function shareTasktoAdmin(Request $request, Task $task)
    {
        if (Gate::allows('isAdmin', Auth::user())) {
            Auth::user()->share()->create([
                'shareable_id' => Auth::user()->id,
                'shareable_type' => 'App\Models\User',
                'task_id' => $task->id,
            ]);
            return response()->json([
                'message' => 'task shared with admin successfully'
            ], 401);
        } else {
            return response()->json([
                'message' => 'you are not admin'
            ], 401);
        }
    }


}
