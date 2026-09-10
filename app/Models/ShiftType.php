<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftType extends Model
{
    use HasFactory;

    protected $table = 'shift_types';

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'description',
        'status',
    ];

    public function staffShifts()
    {
        return $this->hasMany(StaffShift::class, 'shift_type_id');
    }
}