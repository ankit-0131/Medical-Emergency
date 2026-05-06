<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'blood_group',
        // Emergency Contact 1 (Family)
        'emergency_contact_name',
        'emergency_contact_phone',
        'relation',
        // Emergency Contact 2 (Family)
        'emergency_contact2_name',
        'emergency_contact2_phone',
        'emergency_contact2_relation',
        // Emergency Contact 3 (Friend)
        'emergency_contact3_name',
        'emergency_contact3_phone',
        'emergency_contact3_relation',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get all emergencies for this user.
     */
    public function emergencies()
    {
        return $this->hasMany(Emergency::class);
    }

    /**
     * Get the latest emergency for this user.
     */
    public function latestEmergency()
    {
        return $this->hasOne(Emergency::class)->latestOfMany();
    }
}
