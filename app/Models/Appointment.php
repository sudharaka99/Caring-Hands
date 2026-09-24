<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'elder_id',
        'appointment_type',
        'title',
        'doctor_name',
        'hospital_name',
        'location',
        'appointment_date',
        'appointment_time',
        'duration_minutes',
        'reason',
        'instructions',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'duration_minutes' => 'integer',
    ];

    public function elder()
    {
        return $this->belongsTo(Elder::class, 'elder_id');
    }
}