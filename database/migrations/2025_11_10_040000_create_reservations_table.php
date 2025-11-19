<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reservations', function(Blueprint $t){
            $t->id();
            $t->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $t->date('start_date'); $t->date('end_date');
            $t->string('status')->default('new');
            $t->decimal('paid_amount',10,2)->default(0);
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
        });
        Schema::create('guest_reservation', function(Blueprint $t){
            $t->id();
            $t->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
            $t->foreignId('reservation_id')->constrained('reservations')->cascadeOnDelete();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('guest_reservation'); Schema::dropIfExists('reservations'); }
};
