<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'coffee_id',
        'active_theme',
        'active_lang',
        'active_currency',
        'active_timezone',
        'active_direction',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function coffee()
    {
        return $this->belongsTo(Coffee::class);
    }
}
