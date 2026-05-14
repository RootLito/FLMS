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
        Schema::create('fishpond_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lessee_id')->constrained()->onDelete('cascade');
            $table->json('coordinates');
            $table->string('color')->default('#3b82f6');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fishpond_maps');
    }
};
