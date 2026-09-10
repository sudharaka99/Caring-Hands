<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $table = 'manager';

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


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}