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
        Schema::create('lessees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->string('fla_no')->unique(); 
            $table->date('date_issued')->nullable();
            $table->date('date_expiration')->nullable();
            $table->decimal('hec_granted', 10, 2)->default(0);
            $table->decimal('hec_developed', 10, 2)->default(0);
            $table->decimal('hec_undeveloped', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessees');
    }
};
