<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('t003_users', 'remember_token')) {
            Schema::table('t003_users', function (Blueprint $table) {
                $table->rememberToken();
            });
        }

        if (! Schema::hasColumn('t003_mahasiswa', 'user_id')) {
            Schema::table('t003_mahasiswa', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->unique();
                $table->foreign('user_id')->references('id')->on('t003_users')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('t003_mahasiswa', 'user_id')) {
            Schema::table('t003_mahasiswa', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropUnique(['user_id']);
                $table->dropColumn('user_id');
            });
        }

        if (Schema::hasColumn('t003_users', 'remember_token')) {
            Schema::table('t003_users', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
