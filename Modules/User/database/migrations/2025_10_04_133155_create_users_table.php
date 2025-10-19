<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('degree', 64)->nullable();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('country', 64)->nullable();
            $table->text('bio')->nullable();
            $table->string('email', 64)->unique();
            $table->string('password', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('users');
    }
};
