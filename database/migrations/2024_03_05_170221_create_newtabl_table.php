<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->integer('age');
            $table->string('phone');
        });
        //please fixed it
        DB::table('user_details')
            ->join('users', 'user_details.user_id', '=', 'users.id')
            ->update([
                'user_details.age' => DB::raw('users.age'),
                'user_details.phone' => DB::raw('users.phone'),
            ]);
        //please fixed it

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('phone');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
