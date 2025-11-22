<?php
//
//   @file  2025_10_31_082220_add_remember_token_to_users_table.php
//   @author Miroslav Basista (xbasism00@vutbr.cz)
//   @brief Migration to add remember_token column to users table
//   @version 0.1
//   @date 2025-22-11
//
//   @copyright Copyright (c) 2025
//
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->rememberToken()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
