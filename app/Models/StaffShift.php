<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffShift extends Model
{
    use HasFactory;

    protected $table = 'staff_shifts';

    protected $fillable = [
        'user_id',
        'shift_type_id',
        'shift_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'shift_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shiftType()
    {
        return $this->belongsTo(ShiftType::class, 'shift_type_id');
    }
}