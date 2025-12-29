<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'booking_code',

        'device_brand',
        'device_type',
        'serial_number',

        'damage_notes',
        'admin_notes',

        'status',
        'scheduled_at',

        'estimated_cost',
        'total_price',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'estimated_cost' => 'integer',
        'total_price' => 'integer',
    ];

    // ===== Relationships =====

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(BookingStatusLog::class)->latest();
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // ===== Optional Scopes (biar query enak) =====
    public function scopeOfCustomer($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
