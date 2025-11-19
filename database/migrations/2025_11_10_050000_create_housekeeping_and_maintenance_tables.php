<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('housekeeping_tasks', function(Blueprint $t){
            $t->id();
            $t->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $t->text('notes')->nullable();
            $t->boolean('needs_food')->default(false);
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('completed_at')->nullable();
            $t->timestamps();
        });
        Schema::create('maintenance_tickets', function(Blueprint $t){
            $t->id();
            $t->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $t->text('issue');
            $t->text('tools_request')->nullable();
            $t->string('status')->default('open');
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('completed_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('maintenance_tickets'); Schema::dropIfExists('housekeeping_tasks'); }
};
