<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->unsignedInteger('guest_count')->default(1);
            $table->enum('status', ['pending','confirmed','canceled'])->default('pending');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->json('meta')->nullable(); // special requests, notes
            $table->timestamps();
            $table->index(['check_in','check_out']);
        });
    }
    public function down(): void { Schema::dropIfExists('bookings'); }
};
