<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Это поле необходимо для заполнения',
            'name.string'       => 'Данные должны соответствовать строчному типу',
            'email.required'    => 'Это поле необходимо для заполнения',
            'email.string'      => 'Данные должны соответствовать строчному типу',
            'email.email'       => 'Ваша почта должна соответствовать формату mail@some.domain',
            'email.unique'      => 'Пользователь с таким email уже существует',
            'password.required' => 'Это поле необходимо для заполнения',
            'password_confirmation.required' => 'Это поле необходимо для заполнения',
        ];
    }
}
