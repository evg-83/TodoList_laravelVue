<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;

class TagController extends Controller
{
    public function showTag()
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }

    public function storeTag(TaskRequest $request)
    {
        $data = $request->validated();

        $userId = auth()->user()->id;

        $data = [
            'user_id' => $userId,
            'title'   => $request->titleTag,
        ];

        $tag = Tag::firstOrCreate($data);

        $response = [
            'message' => 'Tag successfully created.',
            'data'    => TagResource::make($tag),
        ];

        return response()->json($response, 200);
    }
}
