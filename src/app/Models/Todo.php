<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    protected $fillable = ['category_id', 'content'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeSearch($query, $keyword, $categoryId)
    {
        if (!empty($keyword)) {
            $query->where('content', 'like', "%{$keyword}%");
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        return $query;
    }
}
