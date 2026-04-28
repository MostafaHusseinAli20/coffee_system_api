<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'coffee_id',
        'is_active',
        'added_by',
        'updated_by',
    ];

    public function coffee()
    {
        return $this->belongsTo(Coffee::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

}
