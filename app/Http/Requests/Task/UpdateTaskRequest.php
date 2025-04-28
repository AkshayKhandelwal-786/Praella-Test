<?php
namespace App\Http\Requests\Task;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;

class UpdateTaskRequest extends FormRequest
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
        $status = Task::STATUS;
        $priority = Task::PRIORITY;

        return [
            'title'       => 'required|max:50|unique:tasks,title,'.decrypt($this->task_id),
            'priority'    => 'required|in:'.$priority['low'].','.$priority['medium'].','.$priority['high'],
            'start_date'  => 'required',
            'deadline'    => 'required',
            'project'     => 'required|numeric|exists:projects,id',
            'status'      => 'required|in:'.$status['todo'].','.$status['inprogress'].','.$status['done'],
            'description' => 'required|max:500',
            'file'        => 'nullable|mimes:jpeg,jpg,png,pdf',
        ];
    }
}
