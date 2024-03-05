<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/users', function () {
    $result =DB::table('user_details')
        ->join('users', 'user_details.user_id', '=', 'users.id')
        ->get();

//    $result =DB::table('users')
//        ->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
//        ->whereNull('user_details.id')
//        ->select('users.*')
//        ->get();

    return $result ? $result : "false";
});

Route::get('/users/{id}/details', function ($id) {
    $result = DB::table('users')
        ->join('user_details', 'users.id', '=', 'user_details.user_id')
        ->where('users.id', $id)
        ->select('users.*', 'user_details.email', 'user_details.status')
        ->first();
    return $result ? $result : "Not Found";
});

Route::get('/users/create-one', function () {
    $user = [
        'name' => 'John Doe',
        'age' => 30,
        'phone' => '123-456-7890',
    ];
    $userId = DB::table('users')->insertGetId($user);
    return $userId;
});

Route::get('/users/create', function () {
    DB::beginTransaction();

    try {
        $user = [
            'name' => 'John Doe',
            'age' => 30,
            'phone' => '123-456-7890',
        ];
        $userId = DB::table('users')->insertGetId($user);

        $userDetail = [
            'user_id' => $userId,
            'email' => 'john@example.com',
            'status' => 'active',
        ];
        $userDetailId = DB::table('user_details')->insertGetId($userDetail);
        DB::commit();
        return $userId;
    } catch (\Exception $e) {
        DB::rollback();
        return "Failed to insert user and user detail";
    }
});
