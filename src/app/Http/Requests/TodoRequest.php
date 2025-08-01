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
    /**
     * このリクエストを実行してよいか（認可）を返す。
     *
     * false のままだと、バリデーション以前に 403 Forbidden を返す。
     * つまり「誰もこのリクエストを通過できない」状態になる。
     *
     * 認可を特に分けない（誰でも送信できる）なら true を返す。
     * 逆に、ユーザー権限によって制御したいなら、ここで判定を書く。
     *
     * 例）return auth()->check(); // ログイン済みだけ許可
     */
    public function authorize()
    {
        return true; // ← 実運用するなら true に変更すること！
    }

    /**
     * バリデーションルールを配列で返す。
     * キー：フォームの name、値：適用するルール群
     *
     * ここでは 'content' フィールドに
     * - required : 入力必須
     * - string   : 文字列であること
     * - max:20   : 20文字以内
     * を課している。
     *
     * 記法は配列でも 'required|string|max:20' のようなパイプ記法でもOK（等価）。
     */
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'string',
                'max:20',

            ],
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
