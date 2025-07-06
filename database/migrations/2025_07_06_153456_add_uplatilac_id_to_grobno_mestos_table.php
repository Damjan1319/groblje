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
        Schema::table('grobno_mestos', function (Blueprint $table) {
            $table->foreignId('uplatilac_id')->nullable()->constrained('uplatilacs')->onDelete('set null')->after('lokacija');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grobno_mestos', function (Blueprint $table) {
            $table->dropForeign(['uplatilac_id']);
            $table->dropColumn('uplatilac_id');
        });
    }
};
