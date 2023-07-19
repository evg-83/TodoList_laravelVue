<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'     => 'nullable|string',
            'image'    => 'nullable|file',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Данные должны соответствовать строчному типу',
            'image.file'  => 'Необходимо выбрать файл',
        ];
    }
}