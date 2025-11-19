<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function(Blueprint $t){
            $t->id();
            $t->string('number')->unique();
            $t->unsignedInteger('floor')->default(1);
            $t->foreignId('room_type_id')->constrained('room_types');
            $t->string('status')->default('vacant');
            $t->decimal('price',10,2)->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rooms'); }
};
