<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'role', 'phone', 'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ===== Relationships =====

    // Customer → punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Customer → punya 1 conversation
    public function conversationAsCustomer()
    {
        return $this->hasOne(Conversation::class, 'customer_id');
    }

    // Admin → bisa menangani banyak conversation
    public function conversationsAsAdmin()
    {
        return $this->hasMany(Conversation::class, 'admin_id');
    }

    // User → mengirim banyak message
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Admin/User → mengubah status booking (log)
    public function bookingStatusChanges()
    {
        return $this->hasMany(BookingStatusLog::class, 'changed_by');
    }

    // Helper role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
}
