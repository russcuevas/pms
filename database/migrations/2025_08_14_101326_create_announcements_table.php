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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('admins_id')->nullable();
            $table->string('announcement_subject')->nullable();
            $table->text('announcement_message')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            $table->foreign('admins_id')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
