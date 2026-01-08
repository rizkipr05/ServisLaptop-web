<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str; 

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'service_id', 
        'booking_code',

        // Data Tamu 
        'name',
        'phone',

        'device_brand',
        'device_type',
        'serial_number',

        // Servis
        'service_type',   // Ganti Part / Install Ulang (Pilihan Dropdown)
        'damage_notes',   // Deskripsi kerusakan 
        'admin_notes',

        'status',
        'scheduled_at',

        'estimated_cost',
        'total_price',
        'payment_status', // unpaid/paid (Midtrans)
        'snap_token',     // Token popup bayar (Midtrans)
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'estimated_cost' => 'integer',
        'total_price' => 'integer',
    ];


    // LOGIC TAMBAHAN: Auto-Generate Booking Code

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->booking_code = 'SL-' . date('Y') . '-' . strtoupper(Str::random(5));
        });
    }

    // ===== Relationships =====

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    */

    /*
    public function statusLogs()
    {
        return $this->hasMany(BookingStatusLog::class)->latest();
    }
    */

    /*
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    */

    // ===== Optional Scopes =====
    public function scopeOfCustomer($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}