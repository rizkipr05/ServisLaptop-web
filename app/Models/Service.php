<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description',
        'base_price', 'estimated_days',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_price' => 'integer',
        'estimated_days' => 'integer',
    ];

    // 1 service bisa dipakai banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
