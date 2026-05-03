<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlipCard extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
