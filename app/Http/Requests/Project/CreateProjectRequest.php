<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Project;

class CreateProjectRequest extends FormRequest
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
        $status = Project::STATUS;

        return [
            'name'        => 'required|max:50|unique:projects,name',
            'status'      => 'required|in:'.$status['Active'].','.$status['Inactive'],
            'description' => 'required|max:500',
        ];
    }
}
