<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'country',
        'latitude',
        'longitude',
        'population',
        'description'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'population' => 'integer',
    ];

    public function foreigners()
    {
        return $this->hasMany(Foreigner::class, 'state_province', 'name');
    }

    public function getForeignerCountAttribute()
    {
        return $this->foreigners()->count();
    }

    public function getActiveForeignerCountAttribute()
    {
        return $this->foreigners()->active()->count();
    }
}
