<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'title' => 'sometimes|string|max:40|min:5',
            'description' => 'sometimes|string|min:10|max:255',
            'priority' => 'sometimes|integer|min:1|max:5'
        ];
    }
    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'description.string' => 'The description must be a string.',
            'priority.integer' => 'The priority must be an integer.',
            'title.max' => 'The title must not exceed 40 characters.',
            'description.max' => 'The description must not exceed 255 characters.',
            'title.min' => 'The title must be at least 5 characters.',
            'description.min' => 'The description must be at least 10 characters.',
            'priority.min' => 'The priority must be at least 1.',
            'priority.max' => 'The priority must not exceed 5.',
        ];
    }
}
