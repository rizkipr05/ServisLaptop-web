<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // customer
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();

            $table->string('booking_code')->unique(); // untuk tracking (mis. SV-2025-0001)

            $table->string('device_brand')->nullable();
            $table->string('device_type')->nullable(); // laptop/pc/dll
            $table->string('serial_number')->nullable();

            $table->text('damage_notes'); // detail kerusakan dari customer
            $table->text('admin_notes')->nullable();

            $table->string('status')->default('pending');
            $table->dateTime('scheduled_at')->nullable(); // jadwal datang (opsional)

            $table->unsignedInteger('estimated_cost')->nullable(); // setelah diagnosa (opsional)
            $table->unsignedInteger('total_price')->nullable();    // final

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('booking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
