<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TasksController;
use App\Enums\UserRolesEnum;
use App\Traits\HttpResponses;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum', 'cors']], function(){

    Route::put('/tasks/{task_id}/status', [TasksController::class, 'updateStatus']);

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|get-users"]], function () {
        Route::get('/users', [UserController::class, 'list']);
    });

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|update-users"]], function () {
        Route::put('/users/{user_id}', [UserController::class, 'update']);
    });

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|create-tasks"]], function () {
        Route::post('/tasks', [TasksController::class, 'store']);
    });

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|delete-tasks"]], function () {
        Route::delete('/tasks/{task_id}', [TasksController::class, 'delete']);
    });

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|get-tasks"]], function () {
        Route::get('/tasks', [TasksController::class, 'list']);
    });

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|update-tasks"]], function () {
        Route::put('/tasks/{task_id}', [TasksController::class, 'update']);
    });

    Route::group(['middleware' => ["role_or_permission:{UserRolesEnum::ADMIN->value}|delete-users"]], function () {
        Route::delete('/users/{user_id}', [UserController::class, 'delete']);
    });


});


Route::any('{url}', function(){
    return response()->json(['status' => false, 'message' => 'route_not_found'], 404);
})->where('url', '.*');