<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coffee extends Model
{
    protected $table = 'coffees';
    protected $fillable = [
        'name', 
        'join_date', 
        'logo', 
        'address', 
        'phone', 
        'website', 
        'type'
    ];
}
