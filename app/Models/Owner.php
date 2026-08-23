<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners';

    protected $fillable = [
        'user_id',
        'name',
        'nic',
        'phone',
        'email',
        'address',
        'relationship',
        'photo',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =============================================
    // RELATIONSHIPS
    // =============================================

    /**
     * Get the user associated with the owner.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the elders associated with the owner.
     */
    public function elders()
    {
        return $this->belongsToMany(Elder::class, 'elder_owner');
    }

    // =============================================
    // ACCESSORS
    // =============================================

    /**
     * Get the photo URL.
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="status-badge status-active">Active</span>',
            'inactive' => '<span class="status-badge status-inactive">Inactive</span>',
        ];
        return $badges[$this->status] ?? $this->status;
    }

    // =============================================
    // SCOPES
    // =============================================

    /**
     * Scope a query to only include active owners.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive owners.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to search owners.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('nic', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }
}