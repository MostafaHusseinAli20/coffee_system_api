<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shif extends Model
{
    use HasFactory;
    protected $table = 'shifs';
    protected $fillable = [
        'coffee_id',
        'user_id',
        'total_amount',
        'status',
        'from',
        'to',
        'opened_by',
        'closed_by',
        'notes',
    ];

    public function coffee()
    {
        return $this->belongsTo(Coffee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
