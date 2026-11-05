<?php
/**
 * Student Name : Muhammad Najmi Bin Zakaria
 * Student ID   : SWE24070384
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    public const CATEGORIES = [
        'news',
        'tutorial',
        'opinion'
    ];

    public const STATUSES = [
        'draft',
        'published'
    ];

    protected $fillable = [
        'title',
        'category',
        'reading_time',
        'body',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
