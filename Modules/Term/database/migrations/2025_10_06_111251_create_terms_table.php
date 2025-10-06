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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecturer_id')->nullable()->constrained('users')->onDelete('set null');
            //room
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('name', 64);
            $table->enum('type', ['lecture', 'exercise', 'exam', 'assignment']);
            $table->text('description')->nullable();
            $table->boolean('registration_required');
            $table->tinyInteger('max_score')->unsigned();
            $table->smallInteger('capacity')->unsigned();
            $table->date('event_date');
            $table->time('event_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
