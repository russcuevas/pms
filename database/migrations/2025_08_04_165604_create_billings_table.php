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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();

            $table->string('account_number');
            $table->string('soa_no');
            $table->string('for_the_month_of');
            $table->date('statement_date');
            $table->date('due_date');

            $table->decimal('rental', 10, 2)->nullable();
            $table->decimal('water', 10, 2)->nullable();
            $table->decimal('electricity', 10, 2)->nullable();
            $table->decimal('parking', 10, 2)->nullable();
            $table->decimal('foam', 10, 2)->nullable();
            $table->decimal('previous_balance', 10, 2)->nullable();
            $table->decimal('total_balance_to_pay', 10, 2)->nullable();

            $table->decimal('current_electricity', 10, 2)->nullable();
            $table->decimal('previous_electricity', 10, 2)->nullable();
            $table->decimal('consumption_electricity', 10, 2)->nullable();
            $table->decimal('rate_per_kwh_electricity', 10, 4)->nullable();
            $table->decimal('total_electricity', 10, 2)->nullable();

            $table->decimal('current_water', 10, 2)->nullable();
            $table->decimal('previous_water', 10, 2)->nullable();
            $table->decimal('consumption_water', 10, 2)->nullable();
            $table->decimal('rate_per_cu_water', 10, 4)->nullable();
            $table->decimal('total_water', 10, 2)->nullable();

            $table->string('status')->default('unpaid');
            $table->boolean('is_approved')->default(false);

            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
