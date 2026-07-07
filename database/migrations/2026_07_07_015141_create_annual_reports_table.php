<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annual_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lessee_id')->constrained()->onDelete('cascade');

            $table->date('from')->nullable();
            $table->date('to')->nullable();

            $table->string('fla_no')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->date('date_issued')->nullable();
            $table->date('date_expire')->nullable();
            $table->decimal('no_hec_granted', 10, 2)->nullable();
            $table->decimal('no_hec_developed', 10, 2)->nullable();
            $table->decimal('no_hect_undeveloped', 10, 2)->nullable();

            $table->json('items')->nullable();
            $table->json('stocking')->nullable();
            $table->json('harvesting')->nullable();
            $table->json('marketing')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_reports');
    }
};
