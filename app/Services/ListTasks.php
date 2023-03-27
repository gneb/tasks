<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Task;
use App\Http\Requests\ListTasksRequest;

class ListTasks
{
    public function run(ListTasksRequest $request)
    {  
        $is_user = $request->user()->hasRole(UserRolesEnum::USER->value);
        $tasks = Task::with('user')->select('tasks.*')
        ->leftJoin('users', 'users.id', '=', 'tasks.assignee_id')
        ->when($request->status, function($q) use($request){
            return $q->where('tasks.status', '=', $request->status);
        })
        ->when($request->assignee_id, function($q) use($request){
            return $q->where('tasks.assignee_id', '=', $request->assignee_id);
        })
        ->paginate($request->per_page)->onEachSide(0);

        $tasks->appends([
            'per_page' => $request->per_page, 
            'q' => $request->q, 
            'role' => $request->role,
            'permission' => $request->permission,
        ]);

        return $tasks;
    }
}