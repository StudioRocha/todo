@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if (session('success'))
<div class="todo__alert">
    <div class="todo__alert--success">
        {{ session('success') }}
    </div>
</div>
@endif

@if ($errors->any())
<div class="todo__alert">
    <div class="todo__alert--danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="todo__content">

    {{-- 作成フォーム --}}
    {{-- 新規作成の見出し --}}
    <h2 class="todo__heading">新規作成</h2>
    <form class="create-form" action="{{ route('todos.store') }}" method="post">
        @csrf
        <div class="create-form__item">
            <input
                class="create-form__item-input"
                type="text"
                name="content"
                value="{{ old('id') ? '' : old('content') }}"
                placeholder="Todo内容を入力">
        </div>

        <div class="create-form__item">
            <select class="create-form__item-select" name="category_id">
                <option value="">-- カテゴリ --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>

    {{-- 検索フォーム --}}
    <h2 class="todo__heading">Todo検索</h2>
    <form class="create-form" action="{{ route('todos.search') }}" method="GET">
        <div class="create-form__item">
            <input
                class="create-form__item-input"
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="キーワードで検索">
        </div>

        <div class="create-form__item">
            <select class="create-form__item-select" name="category_id">
                <option value="">-- カテゴリ --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">検索</button>
        </div>
    </form>

    {{-- 一覧テーブル --}}
    <div class="todo-table">
        <table class="todo-table__inner">
            <thead>
                <tr class="todo-table__row">
                    <th class="todo-table__header">Todo</th>
                    <th class="todo-table__header">カテゴリ</th>
                    <th class="todo-table__header"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todos as $todo)
                <tr class="todo-table__row">
                    {{-- Todo入力欄（更新フォームの一部） --}}
                    <td class="todo-table__item">
                        <form action="{{ route('todos.update') }}" method="POST" class="update-form">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $todo->id }}">
                            <input
                                class="update-form__item-input"
                                type="text"
                                name="content"
                                value="{{ old('id') == $todo->id ? old('content') : $todo->content }}">
                    </td>

                    {{-- カテゴリ名 --}}
                    <!-- <td class="todo-table__item">
                        {{ $todo->category->name ?? '未分類' }}
                    </td> -->

                    {{-- カテゴリ名：テキストで直接編集 --}}
                    <td class="todo-table__item">
                        <input
                            class="update-form__item-input"
                            type="text"
                            name="category_name"
                            value="{{ old('category_name', $todo->category->name ?? '未分類') }}">
                    </td>


                    {{-- 更新＆削除 --}}
                    <td class="todo-table__item">
                        <div class="todo-row" style="display: flex; gap: 8px;">
                            <button class="update-form__button-submit" type="submit">更新</button>
                            </form>

                            <form class="delete-form"
                                action="{{ route('todos.destroy') }}"
                                method="POST"
                                onsubmit="return confirm('削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $todo->id }}">
                                <button class="delete-form__button-submit" type="submit">削除</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="todo-table__row">
                    <td class="todo-table__item" colspan="3">Todoはまだありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection