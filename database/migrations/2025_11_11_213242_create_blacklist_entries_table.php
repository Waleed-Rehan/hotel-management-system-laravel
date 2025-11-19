<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('blacklist_entries', function (Blueprint $t) {
            $t->id();
            $t->foreignId('guest_id')->unique()->constrained('guests')->cascadeOnDelete();
            $t->text('reason')->nullable();
            $t->unsignedInteger('incidents_count')->default(0);
            $t->timestamp('last_incident_at')->nullable();
            $t->boolean('active')->default(true);
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('blacklist_entries'); }
};
