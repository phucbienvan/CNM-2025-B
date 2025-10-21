<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:tasks,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }

    public function messages()
    {
        return [
            'id.required' => 'Task ID is required',
            'id.integer' => 'Task ID must be an integer',
            'id.exists' => 'Task not found',
        ];
    }
}