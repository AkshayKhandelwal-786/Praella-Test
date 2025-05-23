<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'project' => 'required|numeric|exists:projects,id',
            'task'    => 'required|numeric|exists:tasks,id',
            'comment' => 'required|max:255',
            'file'    => 'nullable|image|mimes:jpeg,jpg,png'
        ];
    }
}
