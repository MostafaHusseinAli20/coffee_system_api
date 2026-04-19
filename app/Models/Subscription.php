<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'enrollments_count',
        'coffee_id',
        'is_active',
    ];

    public function coffee()
    {
        return $this->belongsTo(Coffee::class);
    }
}
