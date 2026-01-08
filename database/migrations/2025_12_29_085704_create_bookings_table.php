<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Wajib Login)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Kode untuk Tracking 
            $table->string('booking_code')->unique(); 

            // Data Customer
            $table->string('name');
            $table->string('phone');

            // Data Laptop
            $table->string('device_brand')->nullable(); // Merk
            $table->string('device_type')->nullable();  // Laptop/PC/dll
            $table->string('serial_number')->nullable(); // Serial Number opsional

            // Jenis Layanan (Dari Dropdown Form)
            $table->string('service_type')->nullable(); 

            // Detail Kerusakan
            $table->text('damage_notes'); // description dari form masuk kesini
            $table->text('admin_notes')->nullable(); // Catatan teknisi

            // Status & Jadwal
            $table->string('status')->default('pending');
            $table->dateTime('scheduled_at')->nullable(); 

            // Harga & Pembayaran (MIDTRANS)
            $table->unsignedInteger('estimated_cost')->nullable();
            $table->unsignedInteger('total_price')->default(0);
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, failed
            $table->string('snap_token')->nullable(); // Token buat popup bayar

            $table->timestamps();

            // Indexing biar pencarian cepat
            $table->index(['user_id', 'status']);
            $table->index('booking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};