<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/update', [TodoController::class, 'update'])->name('todos.update'); // 追加
Route::delete('/todos/delete', [TodoController::class, 'destroy'])->name('todos.destroy');
