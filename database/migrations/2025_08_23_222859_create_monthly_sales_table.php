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
        Schema::create('monthly_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_sales');
    }
};
