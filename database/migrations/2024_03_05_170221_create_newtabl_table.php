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
            $table->integer('age')->nullable();
            $table->string('phone')->nullable();
        });
        DB::table('user_details')
            ->join('users', 'user_details.user_id', '=', 'users.id')
            ->whereRaw('user_details.age <> users.age OR user_details.phone <> users.phone')
            ->update([
                'user_details.age' => DB::raw('users.age'),
                'user_details.phone' => DB::raw('users.phone'),
            ]);
        DB::table('users')
            ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
            ->whereNull('user_details.id')
            ->select('users.*')
            ->each(function ($user) {
                DB::table('user_details')->insert([
                    'user_id' => $user->id,
                    'email' => '', // Set your default value or leave it empty
                    'status' => '', // Set your default value or leave it empty
                    'age' => $user->age,
                    'phone' => $user->phone,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age');
            $table->string('phone');
        });
        //please fixed it
        DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->update([
                'users.age' => DB::raw('user_details.age'),
                'users.phone' => DB::raw('user_details.phone'),
            ]);
        //please fixed it

        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('phone');
        });
    }
};
