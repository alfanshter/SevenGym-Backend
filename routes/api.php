<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
//MEMBER
Route::post('/addmember', [MemberController::class, 'addmember']);
Route::get('/getmember', [MemberController::class, 'getmember']);
Route::get('/getmemberbulanan', [MemberController::class, 'getmemberbulanan']);
Route::get('/getmemberharian', [MemberController::class, 'getmemberharian']);
Route::get('/getmembertahuan', [MemberController::class, 'getmembertahuan']);
Route::get('/getmembermingguan', [MemberController::class, 'getmembermingguan']);

Route::get('/gettotalmember', [MemberController::class, 'gettotalmember']);
//END MEMBER
});

Route::get('/habismasaberlaku', [MemberController::class, 'habismasaberlaku']);

//ABSEN
Route::post('/addabsent', [AbsenController::class, 'addabsent']);
Route::get('/belumabsen', [AbsenController::class, 'belumabsen']);
Route::get('/sudahabsen', [AbsenController::class, 'sudahabsen']);
//USERS
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
//END USERS

