<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crisis extends Model
{
    protected $guarded = [];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function collectedAmount()
    {
        return $this->donations()
            ->where('status','success')
            ->sum('amount');
    }
}
