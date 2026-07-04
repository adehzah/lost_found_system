<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('found_items', 'reporter_name')) {
            Schema::table('found_items', function (Blueprint $table) {
                $table->string('reporter_name')->nullable()->after('id');
            });
        }

        if (!Schema::hasColumn('found_items', 'matric_number')) {
            Schema::table('found_items', function (Blueprint $table) {
                $table->string('matric_number')->nullable()->after('reporter_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('found_items', 'reporter_name')) {
            Schema::table('found_items', function (Blueprint $table) {
                $table->dropColumn('reporter_name');
            });
        }

        if (Schema::hasColumn('found_items', 'matric_number')) {
            Schema::table('found_items', function (Blueprint $table) {
                $table->dropColumn('matric_number');
            });
        }
    }
};