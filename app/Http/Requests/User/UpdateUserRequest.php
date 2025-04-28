<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $status = User::STATUS;

        return [
            'name'             => 'required|max:50',
            'email'            => 'required|email|unique:users,email,'.decrypt($this->user_id),
            'phone_number'     => 'required|numeric|digits_between:7,15|unique:users,phone_number,'.decrypt($this->user_id),
            'password'         => 'nullable|min:6|max:15',
            'confirm_password' => 'same:password',
            'role'             => 'required|exists:roles,name',
            'project'          => 'required',
            'status'           => 'required|in:'.$status['Active'].','.$status['Inactive'],
            'profile_picture'  => 'image|mimes:jpeg,jpg,png',
            'bio'              => 'max:255',
        ];
    }
}
