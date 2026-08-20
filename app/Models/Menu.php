<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'name',
        'route',
        'icon',
        'parent_id',
        'sort_order',
        'status',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function accesses()
    {
        return $this->hasMany(MenuAccess::class, 'menu_id');
    }
}