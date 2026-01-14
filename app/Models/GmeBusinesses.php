<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GmeBusinesses extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'products' => 'array',
        'photos' => 'array',
        'collaboration_types' => 'array'
    ];
}
