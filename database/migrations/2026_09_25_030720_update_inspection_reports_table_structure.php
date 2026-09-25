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
        Schema::table('inspection_reports', function (Blueprint $table) {
            $table->dropColumn([
                'from',
                'to',
            ]);

            $table->json('improvement')->nullable();
            $table->json('att_photos')->nullable();
            $table->json('operation')->nullable();
            $table->json('verification')->nullable();
            $table->json('case_status')->nullable();
            $table->string('officer')->nullable();
            $table->text('remarks')->nullable();
            $table->string('designation')->nullable();
            $table->json('site_photos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspection_reports', function (Blueprint $table) {
            $table->dropColumn([
                'improvement',
                'att_photos',
                'operation',
                'verification',
                'case_status',
                'officer',
                'remarks',
                'designation',
                'site_photos',
            ]);

            $table->date('from')->nullable();
            $table->date('to')->nullable();
        });
    }
};