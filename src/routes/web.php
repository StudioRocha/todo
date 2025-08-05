<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/update', [TodoController::class, 'update'])->name('todos.update'); // 追加
Route::delete('/todos/delete', [TodoController::class, 'destroy'])->name('todos.destroy');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::patch('/categories/update', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');
// 検索ルートを追加
Route::get('/todos/search', [TodoController::class, 'search'])->name('todos.search');