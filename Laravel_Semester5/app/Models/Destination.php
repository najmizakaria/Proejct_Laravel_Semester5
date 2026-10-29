<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
protected $fillable = [
    'category_id', 'name', 'country', 'price',
    'image', 'description', 'is_featured', 'rating',
];

protected function casts(): array
{
    return [
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
    ];
}

public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}

protected function imageUrl(): Attribute
{
    return Attribute::get(fn () => $this->image
        ? asset($this->image)
        : 'https://placehold.co/600x400?text=Travel+Destination');
}
}
