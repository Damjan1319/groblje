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
        Schema::create('uplatas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grobno_mesto_id')->constrained('grobno_mestos')->onDelete('cascade');
            $table->foreignId('uplatilac_id')->constrained('uplatilacs')->onDelete('cascade');
            $table->foreignId('preminuli_id')->constrained('preminulis')->onDelete('cascade');
            $table->decimal('iznos', 10, 2);
            $table->date('datum_uplate');
            $table->string('period'); // npr. "2024-2025"
            $table->boolean('uplaceno')->default(false);
            $table->text('napomena')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uplatas');
    }
};
