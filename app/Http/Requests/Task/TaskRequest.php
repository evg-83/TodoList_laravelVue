<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'task'        => 'nullable|string',
            'taskUserId'  => 'nullable|integer|exists:users,id',
            'tag'         => 'nullable|string',
            'tagTaskId'   => 'nullable|integer|exists:tasks,id',
            'image'       => 'nullable|file',
            'imageTaskId' => 'nullable|integer|exists:images,id',
        ];
    }

    public function messages()
    {
        return [
            'task.string'         => 'Данные должны соответствовать строчному типу',
            'taskUserId.integer'  => 'Id пользователя должен быть числом',
            'taskUserId.exists'   => 'Id пользователя должен быть в БД',
            'tag.string'          => 'Данные должны соответствовать строчному типу',
            'tagTaskId.integer'   => 'Id task должен быть числом',
            'tagTaskId.exists'    => 'Id task должен быть в БД',
            'image.file'          => 'Необходимо выбрать файл',
            'imageTaskId.integer' => 'Id файла должен быть числом',
            'imageTaskId.exists'  => 'Id файла должен быть в БД',
        ];
    }
}
