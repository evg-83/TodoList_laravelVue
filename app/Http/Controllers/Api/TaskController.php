<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Models\Todolist;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function show()
    {
        $tasks = Task::all();
        // $tags = Task::orderBy('created_at', 'DESC')->get();

        return TaskResource::collection($tasks);
    }

    public function storeTask(TaskRequest $request, Todolist $todolist)
    {
        $data = $request->validated();

        $image = isset($data['imageTask']) ? $data['imageTask'] : "";
        $tags  = isset($data['tag_ids']) ? $data['tag_ids'] : "";

        unset($data['imageTask'], $data['tag_ids']);

        $data = [
            'todolist_id' => $todolist->id,
            'title'       => $request->titleTask,
        ];

        $task = Task::firstOrCreate($data);

        if ($request->hasFile('imageTask')) {
            $name     = md5(now() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

            $task->update([
                'imageTask' => $filePath,
            ]);
        }

        $task->tags()->attach($tags);

        return response()->json([], 200);
        // return TaskResource::make($task);
    }

    public function updateTask(TaskRequest $request, Todolist $todolist, Task $task)
    {
        $data = $request->validated();

        $dataCompleted = isset($data['task']['completed']) ? $data['task']['completed'] : "";

        if ($task) {
            // $task->completed    = $dataCompleted ? true : false;
            // $task->completed_at = $dataCompleted ? Carbon::now() : null;

            $data = [
                'completed'    => $dataCompleted ? true : false,
                'completed_at' => $dataCompleted ? now() : null,
            ];

            $taskUpd = $task->update($data);
        }

        return response()->json([
            'message' => 'Task updated successfully'
        ]);
        // return new TaskResource($taskUpd);
    }

    public function destroyTask(Todolist $todolist, Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}
