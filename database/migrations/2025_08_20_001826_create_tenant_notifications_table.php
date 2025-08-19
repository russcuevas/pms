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
        Schema::create('tenant_notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('property_id');

            $table->string('type'); // e.g., billing, payment
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('url')->nullable();
            $table->json('extra')->nullable();
            $table->boolean('is_view')->default(0);
            $table->timestamps();

            // 🔗 Foreign Keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_notifications');
    }
};
