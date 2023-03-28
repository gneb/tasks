<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Traits\HttpResponses;
use App\Enums\TaskStatusEnum;
use App\Services\ListTasks;
use App\Http\Requests\ListTasksRequest;
use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\EditStatusRequest;

class TasksController extends Controller
{
    use HttpResponses;

    protected $listTasks;

    public function __construct(
        ListTasks $listTasks, 
    ){
        $this->listTasks = $listTasks;
    }

    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());

        $task = Task::create([
            'assignee_id' => $request->assignee_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => TaskStatusEnum::NEW->value,
        ]);

        return $this->success([
            'task' => $task->toArray(),
        ], 'task_created', 200);

    }

    public function list(ListTasksRequest $request)
    {
        return $this->success([
            'tasks' => $this->listTasks->run($request),
        ]);   

    }

    public function update(EditTaskRequest $request, $task_id)
    {
        try {
            $task = Task::findOrFail($task_id);
        } catch (\Throwable $th) {
            return $this->error('', 'task_not_found', 404);
        }

        $request->validated($request->all());

        $task->update($request->all());

        return $this->success([
            'task' => $task->toArray(),
        ], 'task_updated', 200);
    }

    public function updateStatus(EditStatusRequest $request, $task_id)
    {
        try {
            $task = Task::where('assignee_id', '=', $request->user()->id)
            ->where('id', '=', $task_id)
            ->firstOrFail();
        } catch (\Throwable $th) {
            return $this->error('', 'you_cant_update_status_on_this_task', 400);
        }

        $request->validated($request->all());
        $updated = $task->update($request->all());

        return $this->success([
            'task' => $task->toArray(),
        ], 'task_updated', 200);
    }

    public function delete(Request $request, $task_id)
    {
        try {
            $task = Task::findOrFail($task_id);
        } catch (\Throwable $th) {
            return $this->error('', 'task_not_found', 404);
        }

        $request->validated($request->all());

        $task->delete();

        return $this->success('', 'task_deleted', 200);
    }


}
