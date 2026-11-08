<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Kolom ini sudah dipakai model Program & frontend, tetapi belum punya migrasi.
    // Dicek dulu agar aman di database yang kolomnya sudah dibuat manual.
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (! Schema::hasColumn('programs', 'location')) {
                $table->string('location')->nullable()->after('image');
            }
            if (! Schema::hasColumn('programs', 'location_url')) {
                $table->string('location_url')->nullable()->after('location');
            }
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['location', 'location_url']);
        });
    }
};
