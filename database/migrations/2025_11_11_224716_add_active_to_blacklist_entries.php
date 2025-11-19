<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // If you accidentally created a table with an underscore, fix it once.
        if (Schema::hasTable('blacklist_entries_') && !Schema::hasTable('blacklist_entries')) {
            Schema::rename('blacklist_entries_', 'blacklist_entries');
        }

        // Add columns only if they don't exist
        if (Schema::hasTable('blacklist_entries')) {
            if (!Schema::hasColumn('blacklist_entries', 'active')) {
                Schema::table('blacklist_entries', function (Blueprint $t) {
                    $t->boolean('active')->default(true)->after('reason');
                });
            }

            // Optional: if you planned to use this field
            if (!Schema::hasColumn('blacklist_entries', 'last_incident_at')) {
                Schema::table('blacklist_entries', function (Blueprint $t) {
                    $t->timestamp('last_incident_at')->nullable()->after('reason');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('blacklist_entries')) {
            if (Schema::hasColumn('blacklist_entries', 'last_incident_at')) {
                Schema::table('blacklist_entries', function (Blueprint $t) {
                    $t->dropColumn('last_incident_at');
                });
            }
            if (Schema::hasColumn('blacklist_entries', 'active')) {
                Schema::table('blacklist_entries', function (Blueprint $t) {
                    $t->dropColumn('active');
                });
            }
        }
    }
};
