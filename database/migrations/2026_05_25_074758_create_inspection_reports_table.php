<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inspection_reports', function (Blueprint $table) {
            $table->id();

            // Relationship to Lessees
            $table->foreignId('lessee_id')->constrained()->onDelete('cascade');

            // Header Info
            $table->string('fla_no')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->date('date_issued')->nullable();
            $table->date('date_expire')->nullable();
            $table->decimal('no_hec_granted', 10, 2)->nullable();
            $table->decimal('no_hec_developed', 10, 2)->nullable();
            $table->decimal('no_hect_undeveloped', 10, 2)->nullable();

            // JSON Blobs
            $table->json('improvements')->nullable();
            $table->json('financial_values')->nullable();
            $table->json('stocking_records')->nullable();
            $table->json('harvest_records')->nullable();
            $table->json('pond_types')->nullable();

            // Part D, E, F
            $table->boolean('with_pending_admin_case')->default(false);
            $table->text('admin_case_details')->nullable();
            $table->boolean('with_pending_judicial_case')->default(false);
            $table->text('judicial_case_details')->nullable();
            $table->text('remarks_recommendation')->nullable();
            $table->string('inspecting_officer')->nullable();
            $table->date('date_inspection')->nullable();
            $table->string('designation')->nullable();
            $table->json('photos_paths')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspection_reports');
    }
};
