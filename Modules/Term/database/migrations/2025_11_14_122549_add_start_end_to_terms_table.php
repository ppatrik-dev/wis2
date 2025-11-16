<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('terms', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable()->after('event_datetime');
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->dropColumn('event_datetime');
        });
    }

    public function down(): void {
        Schema::table('terms', function (Blueprint $table) {
            $table->dropColumn(['start_at', 'end_at']);
            $table->dateTime('event_datetime')->nullable();
        });
    }
};
