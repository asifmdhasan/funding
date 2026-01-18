<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];
    
    public function crisis()
    {
        return $this->belongsTo(Crisis::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function helpseeker()
    {
        return $this->belongsTo(Helpseeker::class);
    }
}
