@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/category.css') }}">
@endsection

@section('content')

{{-- 成功メッセージ --}}
@if (session('success'))
<div class="todo__alert">
    <div class="todo__alert--success">
        {{ session('success') }}
    </div>
</div>
@endif

{{-- エラーメッセージ --}}
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

    {{-- カテゴリ作成フォーム --}}
    <form class="create-form" action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="create-form__item">
            <input
                class="create-form__item-input"
                type="text"
                name="name"
                value="{{ old('id') ? '' : old('name') }}"
                placeholder="カテゴリ名を入力">
        </div>
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>

    {{-- カテゴリ一覧テーブル --}}
    <div class="todo-table">
        <table class="todo-table__inner">
            <thead>
                <tr class="todo-table__row">
                    <th class="todo-table__header">category</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr class="todo-table__row">
                    <td class="todo-table__item">
                        <div class="todo-row">

                            {{-- 更新フォーム --}}
                            <form class="update-form" action="{{ route('categories.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <input
                                    class="update-form__item-input"
                                    type="text"
                                    name="name"
                                    value="{{ old('id') == $category->id ? old('name') : $category->name }}">
                                <button class="update-form__button-submit" type="submit">更新</button>
                            </form>

                            {{-- 削除フォーム --}}
                            <form class="delete-form"
                                action="{{ route('categories.destroy') }}"
                                method="POST"
                                onsubmit="return confirm('削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <button class="delete-form__button-submit" type="submit">削除</button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr class="todo-table__row">
                    <td class="todo-table__item">カテゴリはまだありません</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection