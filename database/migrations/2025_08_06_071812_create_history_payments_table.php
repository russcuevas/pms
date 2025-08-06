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
        Schema::create('history_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('billings_id')->nullable();
            $table->string('tenant_name');
            $table->string('tenant_phone_number');
            $table->string('tenant_email');

            $table->decimal('amount', 10, 2)->nullable();
            $table->string('for_the_month_of');
            $table->string('reference_number');
            $table->string('mode_of_payment');
            $table->string('type');
            $table->boolean('is_approved')->default(false);

            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('billings_id')->references('id')->on('billings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_payments');
    }
};
