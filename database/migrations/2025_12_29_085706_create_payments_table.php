<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();

            $table->string('provider')->default('midtrans'); // midtrans/dll
            $table->unsignedInteger('amount'); // rupiah
            $table->string('status')->default('unpaid');

            $table->string('provider_ref')->nullable()->index(); // order_id / transaction_id
            $table->string('snap_token')->nullable();            // jika pakai snap
            $table->dateTime('paid_at')->nullable();

            $table->timestamps();

            // 1 booking 1 payment record (kalau mau bisa multiple attempt, hapus unique)
            $table->unique('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
