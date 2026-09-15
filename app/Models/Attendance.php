<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'staff_shift_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'working_hours',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'working_hours' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Staff Shift
    |--------------------------------------------------------------------------
    */

    public function staffShift()
    {
        return $this->belongsTo(
            StaffShift::class,
            'staff_shift_id'
        );
    }
}