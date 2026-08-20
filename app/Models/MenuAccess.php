<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAccess extends Model
{
    protected $table = 'menu_access';

    protected $fillable = [
        'menu_id',
        'role',
        'can_view',
        'can_create',
        'can_edit',
        'can_delete',
    ];

    protected $casts = [
        'can_view' => 'boolean',
        'can_create' => 'boolean',
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}