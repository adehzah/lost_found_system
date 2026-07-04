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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('found_item_id');
            $table->string('claimant_name');
            $table->string('matric_number');
            $table->string('contact_number');
            $table->text('proof_description');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('found_item_id')
                  ->references('id')
                  ->on('found_items')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
