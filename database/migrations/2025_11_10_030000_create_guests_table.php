<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('groups', function(Blueprint $t){
            $t->id(); $t->string('name'); $t->string('color')->nullable(); $t->timestamps();
        });
        Schema::create('guests', function(Blueprint $t){
            $t->id();
            $t->string('name');
            $t->string('nationality')->nullable();
            $t->enum('document_type',['id','passport'])->nullable();
            $t->string('document_number')->nullable();
            $t->unsignedTinyInteger('blacklist_strikes')->default(0);
            $t->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('guests'); Schema::dropIfExists('groups'); }
};
