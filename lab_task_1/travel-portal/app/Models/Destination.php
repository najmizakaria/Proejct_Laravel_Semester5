<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'location',
        'description',
        'image',
        'price',
        'featured',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}