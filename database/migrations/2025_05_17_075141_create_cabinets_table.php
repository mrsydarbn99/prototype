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
        Schema::create('cabinets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ref_type_id')->constrained('ref_types')->onDelete('cascade');
            $table->foreignId('ref_location_id')->constrained('ref_locations')->onDelete('cascade');
            $table->foreignId('ref_cabinet_id')->constrained('ref_cabinets')->onDelete('cascade');
            $table->string('cabinet_no'); // e.g., FLA0001
            $table->boolean('is_occupied')->default(false);
            $table->string('barcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinets');
    }
};
