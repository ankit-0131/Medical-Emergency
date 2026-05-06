<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'address',
        'priority',
        'status',
        'notes',
        'accepted_at',
        'completed_at',
    ];

    /**
     * Cast date fields.
     */
    protected $casts = [
        'accepted_at'  => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user who triggered this emergency.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a Google Maps link from latitude/longitude.
     */
    public function getMapLinkAttribute(): string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return '#';
    }

    /**
     * Get human-readable priority badge color.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'critical' => 'danger',
            'high'     => 'warning',
            'medium'   => 'info',
            'low'      => 'secondary',
            default    => 'secondary',
        };
    }

    /**
     * Get human-readable status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'warning',
            'accepted'    => 'info',
            'in_progress' => 'primary',
            'completed'   => 'success',
            'rejected'    => 'danger',
            default       => 'secondary',
        };
    }
}
