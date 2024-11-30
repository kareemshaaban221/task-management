<?php

namespace App\Http\Requests\Api;

class TaskAssignRequest extends TaskRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return $this->assignRules();
    }
}
