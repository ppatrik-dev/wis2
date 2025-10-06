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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guarantor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('code', 3)->unique();
            $table->string('name', 128);
            $table->string('academic_year', 32);
            $table->text('description')->nullable();
            $table->enum('type', ['mandatory', 'optional']);
            $table->tinyInteger('credits')->unsigned();
            $table->smallInteger('capacity')->unsigned();
            $table->boolean('auto_enroll_confirm');
            $table->boolean('is_approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
