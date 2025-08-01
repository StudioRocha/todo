<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    // ✅ content カラムを操作可能にする
    protected $fillable = ['content']; //一括代入（mass assignment）」できるカラムを指定
}
