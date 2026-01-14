<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GmeBusinessForm extends Model
{
    protected $guarded = [];
    protected $casts = [
        'countries_of_operation' => 'array',
        'founders' => 'array',
        'services_id' => 'array',
        'photos' => 'array',
        'collaboration_types' => 'array',
        'info_accuracy' => 'boolean',
        'allow_publish' => 'boolean',
        'allow_contact' => 'boolean',
    ];

    /**
     * Get the business category
     */
    public function category()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    /**
     * Get the services
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'business_service', 'business_id', 'service_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope for approved businesses
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for pending businesses
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for rejected businesses
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Get founders count
     */
    public function getFoundersCountAttribute()
    {
        return count($this->founders ?? []);
    }

    /**
     * Get first founder name
     */
    public function getFirstFounderNameAttribute()
    {
        $founders = $this->founders;
        return $founders[0]['name'] ?? 'N/A';
    }

    /**
     * Check if business is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if business is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if business is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
