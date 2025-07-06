<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('uplatilacs', function (Blueprint $table) {
            $table->string('imePreminulog')->nullable()->after('telefon');
            $table->string('prezimePreminulog')->nullable()->after('imePreminulog');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uplatilacs', function (Blueprint $table) {
            $table->dropColumn(['imePreminulog', 'prezimePreminulog']);
        });
    }
};
