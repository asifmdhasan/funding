<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Helpseeker extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(HelpseekerPost::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
