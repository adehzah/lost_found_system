<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('found_items', function (Blueprint $table) {
            if (!Schema::hasColumn('found_items', 'reported_by')) {
                $table->string('reported_by')->nullable()->after('id');
            }

            if (!Schema::hasColumn('found_items', 'matric_number')) {
                $table->string('matric_number')->nullable()->after('reported_by');
            }

            if (!Schema::hasColumn('found_items', 'image')) {
                $table->string('image')->nullable()->after('contact_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('found_items', function (Blueprint $table) {
            if (Schema::hasColumn('found_items', 'image')) {
                $table->dropColumn('image');
            }

            if (Schema::hasColumn('found_items', 'matric_number')) {
                $table->dropColumn('matric_number');
            }

            if (Schema::hasColumn('found_items', 'reported_by')) {
                $table->dropColumn('reported_by');
            }
        });
    }
};