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
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('added_by')
                ->after('is_active')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('updated_by')
                ->after('is_active')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('added_by')
                ->after('is_active')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('updated_by')
                ->after('is_active')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['added_by', 'updated_by']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['added_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['added_by', 'updated_by']);
        });
    }
};
