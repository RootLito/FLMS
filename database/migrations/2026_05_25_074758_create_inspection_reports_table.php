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
        Schema::create('inspection_reports', function (Blueprint $table) {
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
            $table->json('site_photos')->nullable();
            $table->json('improvements')->nullable();
            $table->json('financial_values')->nullable();
            $table->json('stocking_records')->nullable();
            $table->json('harvest_records')->nullable();
            $table->json('pond_types')->nullable();
            $table->json('photos_paths')->nullable();
            $table->boolean('with_pending_admin_case')->default(false);
            $table->text('admin_case_details')->nullable();
            $table->boolean('with_pending_judicial_case')->default(false);
            $table->text('judicial_case_details')->nullable();
            $table->text('remarks')->nullable();
            $table->text('remarks_recommendation')->nullable();
            $table->string('inspecting_officer')->nullable();
            $table->date('date_inspection')->nullable();
            $table->string('designation')->nullable();
            $table->text('signature_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_reports');
    }
};