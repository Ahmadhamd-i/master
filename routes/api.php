<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SupervisorController;

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

//Admin Route
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    // EX "http://127.0.0.1:8000/api/auth/login"
    Route::post('/register', [AuthController::class, 'register']);
    // EX "http://127.0.0.1:8000/api/auth/register"
    Route::post('/logout', [AuthController::class, 'logout']);
    // EX "http://127.0.0.1:8000/api/auth/logout"
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    // EX "http://127.0.0.1:8000/api/auth/user-profile"

});

Route::middleware(['jwt.verify'])->group(function () {
    //web Dashboard Apis
    //Supervisor
{
    Route::post('/SV/store', [SupervisorController::class, 'store']);
    Route::get('/SV/getall', [SupervisorController::class, 'index']);
    Route::get('/SV/show/{ID}', [SupervisorController::class, 'getSupervisor']);
    Route::put('/SV/update/{id}', [SupervisorController::class, 'update']);
    Route::delete('/SV/delete/{id}', [SupervisorController::class, 'destroy']);
}

//Parent
{
    Route::get('/parent/getall', [ParentController::class, 'index']);
    Route::Post('/parent/store', [ParentController::class, 'store']);
    Route::get('/parent/show/{id}', [ParentController::class, 'getParent']);
    Route::put('/parent/update/{id}', [ParentController::class, 'update']);
    Route::delete('/parent/delete/{id}', [ParentController::class, 'destroy']);
    /* Route::get('/parent/search/{Keyword}', [ParentController::class, 'search_parent']); */
}
{
    //Student
    Route::get('/student/getall', [StudentController::class, 'index']);
    Route::get('/student/show/{id}', [StudentController::class, 'getStudent']);
    Route::Post('/student/store', [StudentController::class, 'store']);
    Route::put('/student/update/{id}', [StudentController::class, 'update']);
    Route::delete('/student/delete/{id}', [StudentController::class, 'destroy']);
}
});
