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
        Schema::create('grobno_mestos', function (Blueprint $table) {
            $table->id();
            $table->string('sifra')->unique(); // 0001, 0002, ...
            $table->string('oznaka')->unique(); // gm01, gm02, ...
            $table->string('lokacija')->nullable();
            $table->text('napomena')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grobno_mestos');
    }
};
