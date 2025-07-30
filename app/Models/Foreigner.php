<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foreigner extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'nationality',
        'passport_number',
        'photo',
        'date_of_birth',
        'gender',
        'occupation',
        'visa_type',
        'visa_expiry_date',
        'current_address',
        'city',
        'state_province',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'phone_number',
        'email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'entry_date',
        'entry_point',
        'notes',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'visa_expiry_date' => 'date',
        'entry_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Optimize database queries by specifying commonly used fields
    protected static function boot()
    {
        parent::boot();
        
        // Auto-update timestamps efficiently
        static::creating(function ($model) {
            $model->created_at = now();
            $model->updated_at = now();
        });
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsVisaExpiredAttribute()
    {
        return $this->visa_expiry_date < now();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiredVisa($query)
    {
        return $query->where('visa_expiry_date', '<', now());
    }

    public function scopeByNationality($query, $nationality)
    {
        return $query->where('nationality', $nationality);
    }

    public function scopeByRegion($query, $region)
    {
        return $query->where('state_province', $region);
    }

    public function scopeExpiringVisa($query, $days = 30)
    {
        return $query->whereBetween('visa_expiry_date', [now(), now()->addDays($days)]);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeWithCoordinates($query)
    {
        return $query->whereNotNull('latitude')->whereNotNull('longitude');
    }
}
