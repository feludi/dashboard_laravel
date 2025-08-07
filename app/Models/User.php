<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'bio',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        
        // Return default avatar or gravatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is operator
     */
    public function isOperator()
    {
        return $this->role === 'operator';
    }

    /**
     * Check if user can view maps
     */
    public function canViewMaps()
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can view foreigner list
     */
    public function canViewForeignerList()
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can add foreigners
     */
    public function canAddForeigners()
    {
        return true; // Both admin and operator can add
    }

    /**
     * Check if user can import foreigners
     */
    public function canImportForeigners()
    {
        return true; // Both admin and operator can import
    }

    /**
     * Check if user can edit foreigners
     */
    public function canEditForeigners()
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can delete foreigners
     */
    public function canDeleteForeigners()
    {
        return $this->isAdmin();
    }
}
