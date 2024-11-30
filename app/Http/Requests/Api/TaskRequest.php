<?php

namespace App\Http\Requests\Api;

use App\Enums\TaskStatusEnum;

class TaskRequest extends AuthRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'due_date' => 'required|date|date_format:Y-m-d H:i',
            'status' => 'in:' . TaskStatusEnum::toString(),
        ];
    }
}
