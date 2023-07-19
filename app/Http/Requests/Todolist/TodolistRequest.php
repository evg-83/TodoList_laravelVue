<?php

namespace App\Http\Requests\Todolist;

use Illuminate\Foundation\Http\FormRequest;

class TodolistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'          => 'nullable|string',
            'todolistUserId' => 'nullable|integer|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.string'            => 'Данные должны соответствовать строчному типу',
            'todolistUserId.integer' => 'Id пользователя должен быть числом',
            'todolistUserId.exists'  => 'Id пользователя должен быть в БД',
        ];
    }
}
