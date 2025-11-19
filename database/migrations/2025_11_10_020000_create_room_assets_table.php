<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('room_assets', function(Blueprint $t){
            $t->id();
            $t->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $t->string('name');
            $t->boolean('is_available')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('room_assets'); }
};
