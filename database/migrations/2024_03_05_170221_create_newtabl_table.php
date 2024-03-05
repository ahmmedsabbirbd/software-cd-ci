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
                    'phone' => $user->phone
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
            $table->integer('age')->nullable();
            $table->string('phone')->nullable();
        });
        DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->update([
                'users.age' => DB::raw('user_details.age'),
                'users.phone' => DB::raw('user_details.phone'),
            ]);
        DB::table('user_details')
            ->leftJoin('users', 'user_details.user_id', '=', 'users.id')
            ->whereNull('users.id')
            ->select('user_details.*')
            ->each(function ($user) {
                DB::table('users')->insert([
                    'age' => $user->age,
                    'phone' => $user->phone
                ]);
            });
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('phone');
        });
    }
};
