<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TimeOffController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Role;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user()->with(['roles:id,name'])->first();
    return User::where('id', auth()->user()->id)->with(['roles:id,name'])->first();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class)->except([
        'index',
    ]);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('time_offs', TimeOffController::class);
    Route::apiResource('types', TypeController::class);
    Route::get('/get_users', [UserController::class, 'getUsers'])->middleware('isAdmin');
    Route::post('/search_user', [UserController::class, 'searchUser']);
    Route::post('/update_account', [UserController::class, 'updateAccountInfo']);
    Route::get('/get_image_user', [UserController::class, 'getImageUser']);
    Route::post('/change_password', [UserController::class, 'changePassword']);
    Route::post('/upload_user_image', [UserController::class, 'uploadUserImage']);
    Route::get('/managers', [UserController::class, 'allManager']);
    Route::post('/user_details', [UserController::class, 'userDetails']);
    Route::post('/request_time_off/{id}', [TimeOffController::class, 'requestTimeOff']);
    Route::post('/decline_or_approve', [TimeOffController::class, 'declineOrApprove']);
    Route::get('/approved_time_offs', [TimeOffController::class, 'approvedTimeOffs']);
    Route::get('/manager_time_off_from_staff', [TimeOffController::class, 'managerTimeOffFromStaff']);
    Route::post('/search_by_name', [TimeOffController::class, 'searchByName']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
