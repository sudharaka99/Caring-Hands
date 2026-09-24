<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elder extends Model
{
    use HasFactory;

    protected $table = 'elders';

    protected $fillable = [
        'name',
        'elder_code',
        'nic',
        'dob',
        'age',
        'gender',
        'blood_group',
        'phone',
        'email',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'room',
        'caregiver',
        'admission_date',
        'status',
        'medical_notes',
        'photo',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Get the owners for this elder (many-to-many through elder_owner)
     */
    public function owners()
    {
        return $this->belongsToMany(Owner::class, 'elder_owner');
    }

    /**
     * Get the primary owner (first owner)
     */
    public function primaryOwner()
    {
        return $this->belongsToMany(Owner::class, 'elder_owner')->limit(1);
    }

    // =============================================
    // ACCESSORS & MUTATORS
    // =============================================

    /**
     * Get the age from DOB
     */
    public function getAgeAttribute()
    {
        if ($this->dob) {
            return \Carbon\Carbon::parse($this->dob)->age;
        }
        return null;
    }

    /**
     * Get the photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-elder.png');
    }

    /**
     * Get the full address
     */
    public function getFullAddressAttribute()
    {
        return $this->address ?? 'No address provided';
    }

    /**
     * Get gender label
     */
    public function getGenderLabelAttribute()
    {
        $genders = [
            'male' => 'Male',
            'female' => 'Female',
            'other' => 'Other',
        ];
        return $genders[$this->gender] ?? ucfirst($this->gender);
    }

    /**
     * Get the status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="status-badge status-active">Active</span>',
            'inactive' => '<span class="status-badge status-inactive">Inactive</span>',
        ];
        return $badges[$this->status] ?? $this->status;
    }

    /**
     * Get the blood group with label
     */
    public function getBloodGroupLabelAttribute()
    {
        if (!$this->blood_group) {
            return 'Not specified';
        }
        return $this->blood_group;
    }

    // =============================================
    // SCOPES
    // =============================================

    /**
     * Scope a query to only include active elders.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive elders.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include male elders.
     */
    public function scopeMale($query)
    {
        return $query->where('gender', 'male');
    }

    /**
     * Scope a query to only include female elders.
     */
    public function scopeFemale($query)
    {
        return $query->where('gender', 'female');
    }

    /**
     * Scope a query to search elders.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('elder_code', 'LIKE', "%{$search}%")
                ->orWhere('nic', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('room', 'LIKE', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by room.
     */
    public function scopeRoom($query, $room)
    {
        return $query->where('room', $room);
    }

    /**
     * Scope a query to filter by caregiver.
     */
    public function scopeCaregiver($query, $caregiver)
    {
        return $query->where('caregiver', 'LIKE', "%{$caregiver}%");
    }

    // =============================================
    // HELPERS
    // =============================================

    /**
     * Check if elder is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if elder has emergency contact
     */
    public function hasEmergencyContact()
    {
        return !empty($this->emergency_contact_name) || !empty($this->emergency_contact_phone);
    }

    /**
     * Get emergency contact display
     */
    public function getEmergencyContactDisplayAttribute()
    {
        if (!$this->hasEmergencyContact()) {
            return 'No emergency contact provided';
        }
        $parts = [];
        if ($this->emergency_contact_name) {
            $parts[] = $this->emergency_contact_name;
        }
        if ($this->emergency_contact_relationship) {
            $parts[] = '(' . $this->emergency_contact_relationship . ')';
        }
        if ($this->emergency_contact_phone) {
            $parts[] = '- ' . $this->emergency_contact_phone;
        }
        return implode(' ', $parts);
    }

    /**
     * Get owner count
     */
    public function getOwnerCountAttribute()
    {
        return $this->owners()->count();
    }

    /**
     * Get age group
     */
    public function getAgeGroupAttribute()
    {
        $age = $this->age;
        if (!$age) return 'Unknown';
        if ($age < 60) return 'Under 60';
        if ($age < 70) return '60-69';
        if ($age < 80) return '70-79';
        if ($age < 90) return '80-89';
        return '90+';
    }

    public function carePlans()
    {
        return $this->hasMany(
            CarePlan::class,
            'elder_id'
        );
    }

    public function medications()
    {
        return $this->hasMany(Medication::class, 'elder_id');
    }

    public function medicationLogs()
    {
        return $this->hasMany(MedicationLog::class, 'elder_id');
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'elder_id');
    }
}