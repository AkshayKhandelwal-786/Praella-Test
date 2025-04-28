<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'confirm_password' => 'required|same:password',
            'password'         => 'required|min:8|max:15|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'email'            => 'required|email|unique:users,email',
            'name'             => 'required|max:50'
        ];
    }
    public function messages()
    {
        return [
            'password.regex'   => trans('message.valid_password', ['attribute' => 'password']),
        ];
    }
}
