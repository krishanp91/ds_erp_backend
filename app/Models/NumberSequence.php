<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumberSequence extends Model
{
    protected $fillable = [
        'name', 'last_value',
    ];

    protected $casts = [
        'last_value' => 'integer',
    ];
}
