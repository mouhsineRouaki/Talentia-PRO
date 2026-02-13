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
        Schema::table('conversation', function (Blueprint $table) {
            $table->timestamp('user_one_deleted_at')->nullable();
            $table->timestamp('user_two_deleted_at')->nullable();
            $table->timestamp('user_one_archived_at')->nullable();
            $table->timestamp('user_two_archived_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversation', function (Blueprint $table) {
            $table->dropColumn([
                'user_one_deleted_at',
                'user_two_deleted_at',
                'user_one_archived_at',
                'user_two_archived_at',
            ]);
        });
    }
};
