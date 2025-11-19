<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('guest_incidents', function (Blueprint $t) {
            $t->id();
            $t->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
            $t->enum('type', ['late_checkout','damage','complaint','payment_issue','other'])->index();
            $t->text('notes')->nullable();
            $t->foreignId('staff_id')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('occurred_at')->useCurrent();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('guest_incidents'); }
};
