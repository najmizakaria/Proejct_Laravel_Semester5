<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
protected $fillable = ['name'];

public function destinations(): HasMany
{
    return $this->hasMany(Destination::class);
}
}
