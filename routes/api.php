<?php

use App\Http\Controllers\Api\BusesController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SupervisorController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
    Route::get('/parent/show/{id}', [ParentController::class, 'getParent']);
    Route::Post('/parent/store', [ParentController::class, 'store']);
    Route::put('/parent/update/{id}', [ParentController::class, 'update']);
    Route::delete('/parent/delete/{id}', [ParentController::class, 'destroy']);
    /* Route::get('/parent/search/{Keyword}', [ParentController::class, 'search_parent']); */
}
//Student
{
    Route::get('/student/getall', [StudentController::class, 'index']);
    Route::get('/student/show/{id}', [StudentController::class, 'getStudent']);
    Route::Post('/student/store', [StudentController::class, 'store']);
    Route::put('/student/update/{id}', [StudentController::class, 'update']);
    Route::delete('/student/delete/{id}', [StudentController::class, 'destroy']);
}
//Driver   
{
    Route::get('/driver/getall', [DriverController::class, 'index']);
    Route::get('/driver/show/{id}', [DriverController::class, 'getdriver']);
    Route::Post('/driver/store', [DriverController::class, 'store']);
    Route::put('/driver/update/{id}', [DriverController::class, 'update']);
    Route::delete('/driver/delete/{id}', [DriverController::class, 'destroy']);
}
//BusInfo
{
    Route::get('/buses/getall', [BusesController::class, 'index']);
    Route::get('/buses/show/{id}', [BusesController::class, 'getBusinfo']);
    Route::Post('/buses/store', [BusesController::class, 'store']);
    Route::put('/buses/update/{id}', [BusesController::class, 'update']);
    Route::delete('/buses/delete/{id}', [BusesController::class, 'destroy']);
}
