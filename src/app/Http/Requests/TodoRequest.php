<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content'     => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Todoを入力してください',
            'content.string'   => 'Todoを文字列で入力してください',
            'content.max'     => 'Todoを20文字以下で入力してください',
        ];
    }
}
