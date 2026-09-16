<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationLog extends Model
{
    use HasFactory;

    protected $table = 'medication_logs';

    protected $fillable = [
        'medication_id',
        'elder_id',
        'caregiver_id',
        'scheduled_date',
        'scheduled_time',
        'administered_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'administered_at' => 'datetime',
        'scheduled_time' => 'datetime:H:i',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }

    public function elder()
    {
        return $this->belongsTo(Elder::class, 'elder_id');
    }

    public function caregiver()
    {
        return $this->belongsTo(Caregiver::class, 'caregiver_id');
    }
}