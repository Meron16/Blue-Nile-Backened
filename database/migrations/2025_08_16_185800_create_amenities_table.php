<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // "Air conditioning", "Minibar", "Flat-screen TV"
            $table->string('category')->nullable(); // "in-room", "hotel-wide"
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('amenities'); }
};


