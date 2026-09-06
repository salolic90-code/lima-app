<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['name', 'category', 'category_id', 'price', 'stock', 'active'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'active' => 'boolean'];
    }

    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
