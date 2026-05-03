<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $guarded = [];

    protected $casts = [
        'telegram_sent' => 'boolean',
    ];
}
