<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{User, Role};

class CreateUserRequest extends FormRequest
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
        $status = User::STATUS;
        $user = Role::ROLE_NAME['User'];
        $role = ($this->role == $user) ? 'required' : 'nullable';

        return [
            'name'             => 'required|max:50',
            'password'         => 'required|min:6|max:15',
            'confirm_password' => 'required|same:password',
            'phone_number'     => 'required|numeric|digits_between:7,15|unique:users,phone_number',
            'role'             => 'required|exists:roles,name',
            'project'          => $role,
            'email'            => 'required|email|unique:users,email',
            'status'           => 'required|in:'.$status['Active'].','.$status['Inactive'],
            'profile_picture'  => 'image|mimes:jpeg,jpg,png',
            'bio'              => 'max:255',
        ];
    }
}
