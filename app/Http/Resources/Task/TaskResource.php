<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\User\UserResource;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $task = Task::find($this->id);

        return [
            'id'           => $this->id,
            'todolistId'   => $this->todolist_id,
            'title'        => $this->title,
            'imageTask'    => str_replace('images/', 'storage/images/',$this->imageTask),
            'completed'    => $this->completed,
            'completed_at' => $this->completed_at,
            'tags'         => $task->tags,
            // 'user'       => new UserResource($this->user),
        ];
    }
}
