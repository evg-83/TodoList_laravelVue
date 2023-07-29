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
            'titleTask'   => 'nullable|string',
            'taskUserId'  => 'nullable|integer|exists:users,id',
            'task'        => 'nullable',
            'titleTag'    => 'nullable|string',
            'tagUserId'   => 'nullable|integer|exists:users,id',
            'tag_ids'     => 'nullable|array',
            'tag_ids.*'   => 'nullable|integer|exists:tags,id',
            'imageTask'   => 'nullable|file',
            // 'imageTaskId' => 'nullable|integer|exists:images,id',
        ];
    }

    public function messages()
    {
        return [
            'titleTask.string'    => 'Данные должны соответствовать строчному типу',
            'taskUserId.integer'  => 'Id пользователя должен быть числом',
            'taskUserId.exists'   => 'Id пользователя должен быть в БД',
            'titleTag.string'     => 'Данные должны соответствовать строчному типу',
            'tagTaskId.integer'   => 'Id task должен быть числом',
            'tagTaskId.exists'    => 'Id task должен быть в БД',
            'tag_ids.array'       => 'Данные должны соответствовать array',
            'tag_ids.integer'     => 'Id tag должен быть числом',
            'tag_ids.exists'      => 'Id tag должен быть в БД',
            'image.file'          => 'Необходимо выбрать файл',
            'imageTaskId.integer' => 'Id файла должен быть числом',
            'imageTaskId.exists'  => 'Id файла должен быть в БД',
        ];
    }
}
