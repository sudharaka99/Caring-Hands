<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medications';

    protected $fillable = [
        'elder_id',
        'medication_name',
        'generic_name',
        'dosage',
        'dosage_unit',
        'frequency',
        'administration_time',
        'route',
        'start_date',
        'end_date',
        'prescribed_by',
        'purpose',
        'instructions',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'administration_time' => 'datetime:H:i',
    ];

    public function elder()
    {
        return $this->belongsTo(Elder::class, 'elder_id');
    }

    public function logs()
    {
        return $this->hasMany(MedicationLog::class, 'medication_id');
    }
}