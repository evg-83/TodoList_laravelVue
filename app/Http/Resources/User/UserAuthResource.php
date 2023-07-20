<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserAuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userAuth = Auth::user();

        return [
            'id'       => $userAuth->id,
            'name'     => $userAuth->name,
            'email'    => $userAuth->email,
            'password' => $userAuth->password,
            'image'    => str_replace('images/', 'storage/images/', $userAuth->image),
        ];
    }
}
