<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foreigner extends Model
{
    use HasFactory;

    // Fields that can be mass assigned
    protected $fillable = [
        'first_name',
        'last_name',
        'nationality',
        'passport_number',
        'photo',
        'date_of_birth',
        'gender',
        'occupation',
        'residence_permit_type',
        'residence_permit_status',
        'residence_permit_issue_date',
        'residence_permit_expiry_date',
        'current_address',
        'city',
        'state_province',
        'village',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'phone_number',
        'email',
        'sponsor_contact_name',
        'sponsor_contact_number',
        'entry_date',
        'entry_point',
        'accommodation_type',
        'purpose_of_visit',
        'planned_departure_date',
        'notes',
        'status'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'residence_permit_issue_date' => 'date',
        'residence_permit_expiry_date' => 'date',
        'entry_date' => 'date',
        'planned_departure_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();
        
        // Set timestamps when creating new records
        static::creating(function ($model) {
            $model->created_at = now();
            $model->updated_at = now();
        });
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsResidencePermitExpiredAttribute()
    {
        // ITAP (permanent permit) never expires
        if ($this->residence_permit_type === 'ITAP') {
            return false;
        }
        
        return $this->residence_permit_expiry_date && $this->residence_permit_expiry_date < now();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiredResidencePermit($query)
    {
        return $query->where('residence_permit_type', '!=', 'ITAP') // Exclude permanent permits
                    ->where('residence_permit_expiry_date', '<', now());
    }

    public function scopeByNationality($query, $nationality)
    {
        return $query->where('nationality', $nationality);
    }

    public function scopeByRegion($query, $region)
    {
        return $query->where('state_province', $region);
    }

    public function scopeExpiringResidencePermit($query, $days = 30)
    {
        return $query->where('residence_permit_type', '!=', 'ITAP') // Exclude permanent permits
                    ->whereBetween('residence_permit_expiry_date', [now(), now()->addDays($days)]);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeWithCoordinates($query)
    {
        return $query->whereNotNull('latitude')->whereNotNull('longitude');
    }

    /**
     * Get permits that are expiring soon (within specified days)
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('residence_permit_type', '!=', 'ITAP') // Exclude permanent permits
                    ->whereBetween('residence_permit_expiry_date', [now(), now()->addDays($days)])
                    ->whereNotNull('residence_permit_expiry_date');
    }

    /**
     * Get number of days until permit expires
     */
    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->residence_permit_expiry_date || $this->residence_permit_type === 'ITAP') {
            return null;
        }
        
        return now()->diffInDays($this->residence_permit_expiry_date, false);
    }

    /**
     * Check if permit should be marked as expiring soon
     */
    public function shouldBeExpiringSoon($days = 30)
    {
        if ($this->residence_permit_type === 'ITAP' || !$this->residence_permit_expiry_date) {
            return false;
        }
        
        $daysUntilExpiry = $this->days_until_expiry;
        return $daysUntilExpiry !== null && $daysUntilExpiry >= 0 && $daysUntilExpiry <= $days;
    }

    /**
     * Auto-update status based on expiry date
     */
    public function updateStatusBasedOnExpiry()
    {
        // Skip ITAP permits (permanent permits)
        if ($this->residence_permit_type === 'ITAP' || !$this->residence_permit_expiry_date) {
            return;
        }

        $daysUntilExpiry = $this->days_until_expiry;
        
        if ($daysUntilExpiry < 0) {
            // Expired
            if ($this->status !== 'expired') {
                $this->update(['status' => 'expired']);
            }
        } elseif ($daysUntilExpiry <= 30) {
            // Expiring soon
            if ($this->status === 'active') {
                $this->update(['status' => 'expiring_soon']);
            }
        } elseif ($daysUntilExpiry > 30 && $this->status === 'expiring_soon') {
            // Reset to active if no longer expiring soon
            $this->update(['status' => 'active']);
        }
    }
}
