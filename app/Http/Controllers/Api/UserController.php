<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\UserAuth\UserAuthResource;
use App\Http\Resources\User\UserAuthResource as UserAuResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    public function register(AuthRequest $request)
    {
        try {
            $data = $request->validated();

            $data = [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password,
            ];

            $user = User::where('email', $data['email'])->first();

            if ($user) return response(
                [
                    'message' => 'User with this email already exists'
                ]
            );

            $user = User::create($data);

            $token = auth()->tokenById($user->id);

            $response = [
                'message'      => 'User successfully registered.',
                'access_token' => $token,
                'data'         => UserAuthResource::make($user),
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    public function showAuthUser()
    {
        $users = User::all();

        return UserAuResource::collection($users);
    }

    public function editUser()
    {
        $users = User::all();

        return UserAuResource::collection($users);
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $image = isset($data['image']) ? $data['image'] : "";

        unset($data['image']);

        $user->update($data);

        if ($request->hasFile('image')) {
            $name = md5(now() . '_' . $image->getClientOriginalName())
                . '.' . $image->getClientOriginalExtension();
            $filePath = Storage::disk('public')->putFileAs('/images', $image, $name);

            $user->update([
                'image' => $filePath,
            ]);
        }

        return UserResource::make($user);
    }
}
