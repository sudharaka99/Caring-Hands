<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarePlan extends Model
{
    use HasFactory;

    protected $table = 'care_plans';

    protected $fillable = [
        'elder_id',
        'caregiver_id',
        'title',
        'care_needs',
        'goals',
        'activities',
        'start_date',
        'review_date',
        'priority',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'review_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Elder
    |--------------------------------------------------------------------------
    */

    public function elder()
    {
        return $this->belongsTo(
            Elder::class,
            'elder_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Caregiver
    |--------------------------------------------------------------------------
    */

    public function caregiver()
    {
        return $this->belongsTo(
            Caregiver::class,
            'caregiver_id'
        );
    }
}