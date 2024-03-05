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
            $table->string('email')->nullable()->after('phone');
            $table->string('status')->nullable()->after('email');
            $table->dropColumn(['age', 'phone']);
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->integer('age')->nullable()->after('status');
            $table->string('phone')->nullable()->after('age');
            $table->string('father_name')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_details');
    }
};
