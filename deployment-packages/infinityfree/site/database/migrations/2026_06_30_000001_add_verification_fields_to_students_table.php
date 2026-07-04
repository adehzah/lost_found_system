<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            if (!Schema::hasColumn('students', 'phone_verified_at')) {
                $table->timestamp('phone_verified_at')->nullable()->after('phone');
            }
        });

        $now = now();

        if (Schema::hasColumn('students', 'email_verified_at')) {
            DB::table('students')
                ->whereNotNull('email')
                ->whereNull('email_verified_at')
                ->update(['email_verified_at' => $now]);
        }

        if (Schema::hasColumn('students', 'phone_verified_at')) {
            DB::table('students')
                ->whereNotNull('phone')
                ->whereNull('phone_verified_at')
                ->update(['phone_verified_at' => $now]);
        }
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'phone_verified_at')) {
                $table->dropColumn('phone_verified_at');
            }

            if (Schema::hasColumn('students', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }
};
