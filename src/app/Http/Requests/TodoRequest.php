<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Todo 作成リクエスト用のバリデーションをまとめるクラス
 * - コントローラのメソッド引数に TodoRequest を型指定するだけで
 *   バリデーションと認可チェック（authorize）が自動で実行される。
 */
class TodoRequest extends FormRequest
{
   
    public function authorize()
    {
        return true; // ← 実運用するなら true に変更すること！
    }

    
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'], // ✅ 追加
        ];
    }

    // ★ ここでカスタムメッセージを定義
    public function messages(): array
    {
        return [
            'content.required' => 'Todoを入力してください',
            'content.string'   => 'Todoを文字列で入力してください',
            'content.max'      => 'Todoを20文字以下で入力してください',


        ];
    }
}
