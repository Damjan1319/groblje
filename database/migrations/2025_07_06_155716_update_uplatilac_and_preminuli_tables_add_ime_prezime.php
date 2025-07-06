<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update uplatilacs table - check if column exists first
        if (!Schema::hasColumn('uplatilacs', 'ime_prezime')) {
            Schema::table('uplatilacs', function (Blueprint $table) {
                $table->string('ime_prezime')->nullable()->after('id');
            });
        }

        // Update preminulis table - check if column exists first
        if (!Schema::hasColumn('preminulis', 'ime_prezime')) {
            Schema::table('preminulis', function (Blueprint $table) {
                $table->string('ime_prezime')->nullable()->after('id');
            });
        }

        // Migrate existing data (SQLite compatible)
        if (Schema::hasColumn('uplatilacs', 'ime') && Schema::hasColumn('uplatilacs', 'prezime')) {
            DB::statement("UPDATE uplatilacs SET ime_prezime = ime || ' ' || prezime WHERE ime IS NOT NULL AND prezime IS NOT NULL");
            DB::statement("UPDATE uplatilacs SET ime_prezime = ime WHERE ime IS NOT NULL AND (prezime IS NULL OR prezime = '')");
            DB::statement("UPDATE uplatilacs SET ime_prezime = prezime WHERE prezime IS NOT NULL AND (ime IS NULL OR ime = '')");
        }

        if (Schema::hasColumn('preminulis', 'ime') && Schema::hasColumn('preminulis', 'prezime')) {
            DB::statement("UPDATE preminulis SET ime_prezime = ime || ' ' || prezime WHERE ime IS NOT NULL AND prezime IS NOT NULL");
            DB::statement("UPDATE preminulis SET ime_prezime = ime WHERE ime IS NOT NULL AND (prezime IS NULL OR prezime = '')");
            DB::statement("UPDATE preminulis SET ime_prezime = prezime WHERE prezime IS NOT NULL AND (ime IS NULL OR ime = '')");
        }

        // Drop old columns if they exist
        if (Schema::hasColumn('uplatilacs', 'ime') && Schema::hasColumn('uplatilacs', 'prezime')) {
            Schema::table('uplatilacs', function (Blueprint $table) {
                $table->dropColumn(['ime', 'prezime']);
            });
        }

        if (Schema::hasColumn('preminulis', 'ime') && Schema::hasColumn('preminulis', 'prezime')) {
            Schema::table('preminulis', function (Blueprint $table) {
                $table->dropColumn(['ime', 'prezime']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back old columns
        Schema::table('uplatilacs', function (Blueprint $table) {
            $table->string('ime')->after('id');
            $table->string('prezime')->after('ime');
        });

        Schema::table('preminulis', function (Blueprint $table) {
            $table->string('ime')->after('id');
            $table->string('prezime')->after('ime');
        });

        // Drop new column
        Schema::table('uplatilacs', function (Blueprint $table) {
            $table->dropColumn('ime_prezime');
        });

        Schema::table('preminulis', function (Blueprint $table) {
            $table->dropColumn('ime_prezime');
        });
    }
};
