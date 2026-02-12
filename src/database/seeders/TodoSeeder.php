<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $unsorted = Category::where('name', '未分類')->first();
        $work = Category::where('name', '仕事')->first();
        $private = Category::where('name', 'プライベート')->first();
        $shopping = Category::where('name', '買い物')->first();

        if (!$unsorted || !$work || !$private || !$shopping) {
            $this->command->warn('先に CategorySeeder を実行してください。');
            return;
        }

        $todos = [
            ['category_id' => $work->id, 'content' => 'メール返信'],
            ['category_id' => $work->id, 'content' => '報告書作成'],
            ['category_id' => $private->id, 'content' => 'ジムに行く'],
            ['category_id' => $private->id, 'content' => '本を読む'],
            ['category_id' => $shopping->id, 'content' => '牛乳を買う'],
            ['category_id' => $shopping->id, 'content' => '洗剤を買う'],
            ['category_id' => $unsorted->id, 'content' => 'その他タスク'],
        ];

        foreach ($todos as $todo) {
            Todo::firstOrCreate(
                [
                    'content'     => $todo['content'],
                    'category_id' => $todo['category_id'],
                ],
                $todo
            );
        }
    }
}
