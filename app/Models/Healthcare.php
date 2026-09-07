<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Healthcare extends Model
{
    use HasFactory;

    protected $table = 'healthcare';

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
        'specialization',
        'qualifications',
        'experience',
        'emergency_contact_name',
        'emergency_relationship',
        'emergency_phone',
        'notes',

    ];


    // User account
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}