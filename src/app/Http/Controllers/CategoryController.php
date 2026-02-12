<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id')->get();
        return view('category', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return back()->with('success', 'カテゴリを作成しました');
    }

    public function update(CategoryRequest $request)
    {
        $category = Category::findOrFail($request->input('id'));
        $category->update($request->validated());
        return back()->with('success', 'カテゴリを更新しました');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        Category::whereKey($request->input('id'))->delete();
        return back()->with('success', 'カテゴリを削除しました');
    }
}
