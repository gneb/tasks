<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TaskStatusEnum;

class EditTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'min:2', 'max:64', 'unique:tasks,name,'. $this->user()->id],
            'assignee_id' => ['integer', 'exists:users,id'],
            'description' => [ 'string'],
            'status' => Rule::in(array_map(fn($status): string => $status->value, TaskStatusEnum::cases())),
        ];
    }
}
