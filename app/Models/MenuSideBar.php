<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSideBar extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'icon',
        'style',
        'parent_id',
        'level',
        'route',
        'acl',
        'order',
        'active',
        'group',
    ];
    protected $casts = [
        'active' => 'boolean',
        'parent_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(MenuSideBar::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuSideBar::class, 'parent_id');
    }
}
