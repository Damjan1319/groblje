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
        Schema::table('uplatas', function (Blueprint $table) {
            $table->string('za_koga')->nullable()->after('preminuli_id');
            $table->dropForeign(['preminuli_id']);
            $table->dropColumn('preminuli_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uplatas', function (Blueprint $table) {
            $table->foreignId('preminuli_id')->nullable()->constrained('preminulis')->onDelete('cascade');
            $table->dropColumn('za_koga');
        });
    }
};
