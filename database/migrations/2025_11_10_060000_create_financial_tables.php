<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('financial_transactions', function(Blueprint $t){
            $t->id();
            $t->enum('type',['in','out']);
            $t->decimal('amount',10,2);
            $t->string('description')->nullable();
            $t->date('effective_on')->index();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
        });
        Schema::create('blacklist_entries', function(Blueprint $t){
            $t->id();
            $t->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
            $t->string('reason')->nullable();
            $t->unsignedTinyInteger('strikes')->default(1);
            $t->timestamps();
        });
        Schema::create('staff_rewards', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->decimal('amount',10,2);
            $t->string('reason')->nullable();
            $t->date('effective_on');
            $t->timestamps();
        });
        Schema::create('staff_penalties', function(Blueprint $t){
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->decimal('amount',10,2);
            $t->string('reason')->nullable();
            $t->date('effective_on');
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('staff_penalties');
        Schema::dropIfExists('staff_rewards');
        Schema::dropIfExists('blacklist_entries');
        Schema::dropIfExists('financial_transactions');
    }
};
