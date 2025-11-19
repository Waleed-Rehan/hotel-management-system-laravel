<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop blacklist-related tables if they exist
        if (Schema::hasTable('blacklist_incidents')) {
            Schema::drop('blacklist_incidents');
        }
        if (Schema::hasTable('blacklist_entries')) {
            Schema::drop('blacklist_entries');
        }
        // Some projects had a mistaken name (trailing underscore)
        if (Schema::hasTable('blacklist_entries_')) {
            Schema::drop('blacklist_entries_');
        }

        // Remove column from guests if present
        if (Schema::hasColumn('guests', 'blacklist_strikes')) {
            Schema::table('guests', function (Blueprint $t) {
                $t->dropColumn('blacklist_strikes');
            });
        }
    }

    public function down(): void
    {
        // Intentionally left blank (we're removing the feature)
        // If you want, you could recreate the schema here.
    }
};
