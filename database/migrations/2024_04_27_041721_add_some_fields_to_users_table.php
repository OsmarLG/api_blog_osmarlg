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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('email');
            $table->json('address')->nullable()->after('username');
            $table->string('phone')->nullable()->after('address');
            $table->string('website')->nullable()->after('phone');
            $table->json('company')->nullable()->after('website');
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('website');
            $table->dropColumn('company');
        });
    }
};
