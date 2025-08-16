<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // e.g., Superior Room, Junior Suite
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('guest_capacity')->default(2);
            $table->unsignedInteger('beds_count')->default(1);
            $table->boolean('has_lake_view')->default(false);
            $table->boolean('has_balcony')->default(false);
            $table->decimal('base_price', 10, 2);   // default nightly rate
            $table->json('images')->nullable();     // array of URLs/paths
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('room_types'); }
};
