<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Get the caregiver profile associated with the user.
     */
    public function caregiver()
    {
        return $this->hasOne(Caregiver::class, 'user_id');
    }

    /**
     * Get the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the reservations for the user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // =============================================
    // SCOPES
    // =============================================

    /**
     * Scope a query to only include caregivers.
     */
    public function scopeCaregivers($query)
    {
        return $query->where('role', 'caregiver');
    }

    /**
     * Scope a query to only include admins.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope a query to only include managers.
     */
    public function scopeManagers($query)
    {
        return $query->where('role', 'manager');
    }

    /**
     * Scope a query to only include healthcare workers.
     */
    public function scopeHealthcare($query)
    {
        return $query->where('role', 'healthcare');
    }

    // =============================================
    // ACCESSORS & MUTATORS
    // =============================================

    /**
     * Get the user's role label.
     */
    public function getRoleLabelAttribute()
    {
        $roles = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'caregiver' => 'Caregiver',
            'healthcare' => 'Healthcare Worker',
        ];

        return $roles[$this->role] ?? ucfirst($this->role);
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return $initials;
    }

    /**
     * Get the user's display name with role.
     */
    public function getDisplayNameAttribute()
    {
        return $this->name . ' (' . $this->role_label . ')';
    }

    // =============================================
    // ROLE CHECKS
    // =============================================

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a manager.
     */
    public function isManager()
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is a caregiver.
     */
    public function isCaregiver()
    {
        return $this->role === 'caregiver';
    }

    /**
     * Check if user is a healthcare worker.
     */
    public function isHealthcare()
    {
        return $this->role === 'healthcare';
    }

    /**
     * Check if user has any role.
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    public function attendances()
    {
        return $this->hasMany(
            \App\Models\Attendance::class,
            'user_id'
        );
    }
}