<?php

namespace App\Models;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }
}
