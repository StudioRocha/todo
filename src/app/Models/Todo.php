<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    // ✅ content カラムを操作可能にする
    protected $fillable = ['category_id', 'content']; //一括代入（mass assignment）」できるカラムを指定

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $keyword, $categoryId)
    {
        // ✅ キーワードが入力されていれば「content」カラムに対して部分一致で検索を実行
        if (!empty($keyword)) {
            $query->where('content', 'like', "%{$keyword}%");
        }

        // ✅ カテゴリIDが指定されていれば「category_id」カラムで一致するレコードを絞り込む
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // ✅ クエリビルダを返す（チェーンで続けて使えるように）
        return $query;
    }
}
