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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 255);
            $table->string('username', 50)->unique()->nullable();
            $table->string('password', 255)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone_number', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->date('move_in_date')->nullable();
            $table->date('move_out_date')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->decimal('advance_deposit', 10, 2)->nullable();
            $table->string('contact_fullname', 255)->nullable();
            $table->string('contact_phone_number', 255)->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->string('otp_code', 255)->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
