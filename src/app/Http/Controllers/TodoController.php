<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('category')->get();
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }

    public function store(TodoRequest $request)
    {
        $data = $request->validated();
        $categoryId = $request->input('category_id')
            ?? Category::firstOrCreate(['name' => '未分類'])->id;

        Todo::create([
            'content'     => $data['content'],
            'category_id' => $categoryId,
        ]);

        return redirect('/')->with('success', 'Todoを作成しました');
    }

    public function update(TodoRequest $request)
    {
        $data = $request->validated();
        $todo = Todo::with('category')->findOrFail($request->input('id'));

        $todo->content = $data['content'];

        $categoryName = $request->input('category_name');
        if (!empty($categoryName) && $todo->category) {
            $todo->category->name = $categoryName;
            $todo->category->save();
        }

        $todo->save();

        return redirect('/')->with('success', 'Todoとカテゴリを更新しました');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:todos,id'],
        ]);

        Todo::whereKey($request->input('id'))->delete();

        return redirect('/')->with('success', 'Todoを削除しました');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category_id');

        $todos = Todo::with('category')
            ->search($keyword, $categoryId)
            ->get();

        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }
}
