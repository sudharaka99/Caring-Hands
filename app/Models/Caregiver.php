<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caregiver extends Model
{
    use HasFactory;

    // Specify the table name explicitly (singular)
    protected $table = 'caregiver';

    protected $fillable = [
        'user_id',
        'staff_code',
        'nic',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'profile_photo',
        'joining_date',
        'employment_type',
        'emergency_contact_name',
        'emergency_relationship',
        'emergency_phone',
        'qualifications',
        'experience',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->user->name ?? 'N/A';
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? 'N/A';
    }

    public function getStatusAttribute()
    {
        return $this->user->status ?? 'inactive';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeInactive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('status', 'inactive');
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('staff_code', 'LIKE', "%{$search}%")
                ->orWhere('nic', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
        });
    }

    public function carePlans()
    {
        return $this->hasMany(
            CarePlan::class,
            'caregiver_id'
        );
    }

    public function medicationLogs()
    {
        return $this->hasMany(MedicationLog::class, 'caregiver_id');
    }
}