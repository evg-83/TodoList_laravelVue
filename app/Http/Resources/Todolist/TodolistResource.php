<?php

namespace App\Http\Resources\Todolist;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodolistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'user_id' => $this->user_id,
            'title'   => $this->title,
            'user'    => new UserResource($this->user),
        ];
    }
}
