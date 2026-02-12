<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->input('id');

        return [
            'name' => [
                'required',
                'string',
                'max:10',
                Rule::unique('categories', 'name')->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'カテゴリを入力してください',
            'name.string'   => 'カテゴリを文字列で入力してください',
            'name.max'      => 'カテゴリを10文字以下で入力してください',
            'name.unique'   => 'カテゴリが既に存在しています',
        ];
    }
}
