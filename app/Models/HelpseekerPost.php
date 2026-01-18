<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpseekerPost extends Model
{
    protected $guarded = [];

    public function helpseeker()
    {
        return $this->belongsTo(Helpseeker::class);
    }

    /**
     * Donations received for this post
     */
    public function donations()
    {
        return $this->hasMany(Donation::class, 'helpseeker_post_id');
    }

    /**
     * Get collected amount
     */
    public function collectedAmount()
    {
        return $this->donations()
                    ->where('status', 'success')
                    ->sum('amount');
    }
}
