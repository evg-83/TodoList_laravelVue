<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todolist\TodolistRequest;
use App\Http\Resources\Todolist\TodolistResource;
use App\Models\Todolist;

class TodolistController extends Controller
{
    public function index()
    {
        $todolists = Todolist::all();
        // $users = User::all();

        // $response = [
        //     TaskResource::collection($tasks),
        //     UserAuthResource::collection($users),
        // ];

        return TodolistResource::collection($todolists);
    }

    public function storeTodolist(TodolistRequest $request)
    {
        $data = $request->validated();

        $userId = auth()->user()->id;

        $data = [
            'user_id' => $userId,
            'title'   => $request->title,
        ];

        $todolist = Todolist::firstOrCreate($data);

        $response = [
            'message' => 'User successfully registered.',
            'data'    => TodolistResource::make($todolist),
        ];

        return response()->json($response, 200);
    }

    public function showTodolist(Todolist $todolist)
    {
        return TodolistResource::collection($todolist);
    }

    public function edit()
    {
        # code...
    }
}
