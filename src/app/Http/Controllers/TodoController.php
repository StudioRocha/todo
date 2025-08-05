<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\Category;       // ← これが必要（モデル）
use Illuminate\Http\Request;


class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')->get();  // categoryも一緒に取得
        $categories = Category::all();           // セレクトボックスに使用

        return view('index', compact('todos', 'categories'));
    }


    public function store(TodoRequest $request)
    {
        $data = $request->validated(); // ['content' => ...]
        // フォームからのカテゴリ選択（必須で送る or 無ければ未分類にフォールバック）
        $categoryId = $request->input('category_id')
            ?? Category::firstOrCreate(['name' => '未分類'])->id;

        Todo::create([
            'content'     => $data['content'],
            'category_id' => $categoryId,     // ← ここが必須
        ]);

        return redirect('/')->with('success', 'Todoを作成しました');
    }
    

    public function update(TodoRequest $request)
    {
        // content の検証は TodoRequest（既存ルール）で実行済み
        $data = $request->validated(); // ['content' => '...']

        // id はフォームから受け取って該当レコード取得
        $todoId = $request->input('id');
        $todo   = Todo::findOrFail($todoId);

        $todo->update([
        'content' => $data['content'],
        'category_id' => $request->input('category_id') ?? $todo->category_id,
    ]);

        return redirect('/')->with('success', 'Todoを更新しました');
    }

    public function destroy(Request $request)
    {
        // id は FormRequestを使わない前提なので、ここだけ軽く検証
        $request->validate([
            'id' => ['required', 'integer', 'exists:todos,id'],
        ]);

        Todo::whereKey($request->input('id'))->delete();

        return redirect('/')->with('success', 'Todoを削除しました');
    }

    public function search(Request $request)
    {
        // ✅ フォームから送られてきた検索ワードを取得（input name="keyword"）
        $keyword = $request->input('keyword');

        // ✅ セレクトボックスで選ばれたカテゴリIDを取得（input name="category_id"）
        $categoryId = $request->input('category_id');

        // ✅ モデルのローカルスコープ `search()` を使って検索条件を適用
        // with('category') はリレーション読み込み（N+1問題の回避）
        $todos = Todo::with('category')
            ->search($keyword, $categoryId)
            ->get();

        // ✅ カテゴリ一覧を取得して、セレクトボックスに再表示するために使う
        $categories = Category::all();

        // ✅ 検索結果（todos）とカテゴリ一覧（categories）をビューに渡して表示
        return view('index', compact('todos', 'categories'));
    }
}
