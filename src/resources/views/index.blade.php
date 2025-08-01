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
    <form class="create-form" action="{{ route('todos.store') }}" method="post">
        @csrf
        <div class="create-form__item">
            {{-- 更新エラーの old('content') が乗らないように、old('id') が無い時のみ表示 --}}
            <input
                class="create-form__item-input"
                type="text"
                name="content"
                value="{{ old('id') ? '' : old('content') }}"
                placeholder="Todo内容を入力">
        </div>
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>

    {{-- 一覧テーブル（ここだけ残す） --}}
    <div class="todo-table">
        <table class="todo-table__inner">
            <thead>
                <tr class="todo-table__row">
                    <th class="todo-table__header">Todo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todos as $todo)
                <tr class="todo-table__row">
                    <td class="todo-table__item">
                        <div class="todo-row">
                            {{-- 更新フォーム（PATCH /todos/update）--}}
                            <form class="update-form" action="{{ route('todos.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{ $todo->id }}">
                                <input
                                    class="update-form__item-input"
                                    type="text"
                                    name="content"
                                    value="{{ old('id') == $todo->id ? old('content') : $todo->content }}">
                                <button class="update-form__button-submit" type="submit">更新</button>
                            </form>

                            {{-- 削除フォーム（DELETE /todos/delete）--}}
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
                    <td class="todo-table__item">Todoはまだありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection