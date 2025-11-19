<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('room_types', function(Blueprint $t){
            $t->id();
            $t->string('name');
            $t->unsignedInteger('capacity')->default(1);
            $t->unsignedInteger('beds')->default(1);
            $t->decimal('base_price',10,2)->default(0);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('room_types'); }
};
