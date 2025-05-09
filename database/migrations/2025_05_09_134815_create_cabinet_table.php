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
            $table->integer('cabinet_number')->unique();
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('cabinet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabinet_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('barcode');
            $table->enum('action', ['check_in', 'check_out']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabinet_transactions');
        Schema::dropIfExists('cabinets');
    }
};
