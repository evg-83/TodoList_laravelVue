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

    public function store(TodolistRequest $request)
    {
        $data = $request->validated();

        $userId = auth()->user()->id;

        $data = [
            'user_id' => $userId,
            'title'   => $request->title,
        ];

        $todolist = Todolist::firstOrCreate($data);

        $response = [
            'message' => 'Todolist successfully created.',
            'data'    => TodolistResource::make($todolist),
        ];

        return response()->json($response, 200);
    }

    public function show(Todolist $todolist)
    {
        return new TodolistResource($todolist);
    }

    public function destroy(Todolist $todolist)
    {
        $todolist->delete();

        return response([
            'message' => 'Todolist successfully deleted.'
        ]);
    }
}
