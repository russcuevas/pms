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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->date('date');
            $table->string('salaries');
            $table->string('labor_for_repair');
            $table->string('materials');
            $table->string('food');
            $table->string('taxes');
            $table->string('miscellaneous');
            $table->string('water_electricity');
            $table->string('refund');
            $table->string('office_supplies');
            $table->string('remarks');
            $table->boolean('is_approved')->default(false);
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
