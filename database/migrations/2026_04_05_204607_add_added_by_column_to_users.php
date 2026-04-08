<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('added_by')
                ->after('active')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignId('updated_by')
                ->after('added_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
            $table->dropColumn('added_by');
            $table->dropForeign(['updated_by']);
            $table->dropColumn('updated_by');
        });
    }
};
