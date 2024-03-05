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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('phone');
            $table->timestamps();
        });
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('email');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('user_details', function (Blueprint $table) {
            $table->integer('age');
            $table->string('phone');
        });
        //please fixed it
        DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->update([
                'users.age' => DB::raw('user_details.age'),
                'users.phone' => DB::raw('user_details.phone')
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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age');
            $table->string('phone');
        });
        DB::statement('UPDATE users INNER JOIN user_details ON users.id = user_details.user_id SET users.age = user_details.age, users.phone = user_details.phone');
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('phone');
        });



        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('father_name');
        });
        DB::statement('UPDATE user_details INNER JOIN users ON user_details.user_id = users.id SET user_details.email = users.email, user_details.status = users.status');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('status');
        });
    }
};
