<?php

namespace App\Models;

use Database\Factories\DestinationFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Destination extends Model
{
    /** @use HasFactory<DestinationFactory> */
    use HasFactory;

    // Safe whitelist for mass assignment (create / update)
    protected $fillable = [
        'category_id',
        'name',
        'country',
        'price',
        'image',
        'description',
        'is_featured',
        'rating',
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

    /** Full image URL, or a placeholder when no image path is stored. */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image
            ? asset($this->image)
            : 'https://placehold.co/600x400?text=Travel+Destination');
    }
}
