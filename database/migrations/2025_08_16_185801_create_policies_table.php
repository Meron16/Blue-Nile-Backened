<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('type');     // "checkin", "checkout", "children", "pets", "payments", etc.
            $table->text('content');    // rich text / markdown
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('policies'); }
};

