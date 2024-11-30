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
        return $this->storeRules();
    }

    protected function storeRules(): array
    {
        return [
            'title'         => 'required|string',
            'description'   => 'required|string',
            'due_date'      => 'required|date|date_format:Y-m-d H:i',
            'status'        => 'in:' . TaskStatusEnum::toString(),
        ];
    }

    protected function updateRules(): array
    {
        return [
            'title'         => 'string',
            'description'   => 'string',
            'due_date'      => 'date|date_format:Y-m-d H:i',
            'status'        => 'in:' . TaskStatusEnum::toString(),
        ];
    }

    protected function assignRules(): array
    {
        return [
            'title'         => 'required|string',
            'description'   => 'required|string',
            'due_date'      => 'required|date|date_format:Y-m-d H:i',
            'user_email'    => 'required|exists:users,email',
            'status'        => 'in:' . TaskStatusEnum::toString(),
        ];
    }
}
