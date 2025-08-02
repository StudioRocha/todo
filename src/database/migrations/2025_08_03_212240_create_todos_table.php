<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            // 外部キー（カテゴリ削除時に紐づくTodoも削除：仕様に合わせて変更可）
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            //constrained() 外部キー制約による共有
            //cascadeOnDelete() 

            $table->string('content', 20); // 20文字以内にするなら
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todos');
    }
}
