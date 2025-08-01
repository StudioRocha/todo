<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();

        return view('index', compact('todos'));
    }

    public function store(TodoRequest $request)
    {
        $data = $request->validated();       // ← ここがポイント
        Todo::create($data);

        return redirect('/')->with('success', 'Todoを作成しました'); // Bladeとキーを揃える
    }

    public function update(TodoRequest $request)
    {
        // content の検証は TodoRequest（既存ルール）で実行済み
        $data = $request->validated(); // ['content' => '...']

        // id はフォームから受け取って該当レコード取得
        $todoId = $request->input('id');
        $todo   = Todo::findOrFail($todoId);

        // 内容を更新
        $todo->update(['content' => $data['content']]);

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
}
