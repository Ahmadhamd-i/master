<?php

use App\Http\Controllers\Api\Auth2Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BusesController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\ParentAppController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SupervisorController;
use App\Http\Controllers\Api\SVappController;

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

//Web Admin dashboard Apis
{
    /*  Route::middleware(['jwt.verify'])->group(function () { */
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
    } {
        //Student
        Route::get('/student/getall', [StudentController::class, 'index']);
        Route::get('/student/show/{id}', [StudentController::class, 'getStudent']);
        Route::Post('/student/store', [StudentController::class, 'store']);
        Route::put('/student/update/{id}', [StudentController::class, 'update']);
        Route::delete('/student/delete/{id}', [StudentController::class, 'destroy']);
    }
    //Buses
    {
        Route::post('/buses/store', [BusesController::class, 'store']);
        Route::get('/buses/getall', [BusesController::class, 'index']);
        Route::get('/buses/show/{ID}', [BusesController::class, 'getBusInfo']);
        Route::put('/buses/update/{id}', [BusesController::class, 'update']);
        Route::delete('/buses/delete/{id}', [BusesController::class, 'destroy']);
    }
    //Drivers
    {
        Route::post('/driver/store', [DriverController::class, 'store']);
        Route::get('/driver/getall', [DriverController::class, 'index']);
        Route::get('/driver/show/{ID}', [DriverController::class, 'getDriver']);
        Route::put('/driver/update/{id}', [DriverController::class, 'update']);
        Route::delete('/driver/delete/{id}', [DriverController::class, 'destroy']);
    }
}/* );
} */

//Application Apis
{
    //LogIn And LogOut Supervisor Parent

    Route::controller(Auth2Controller::class)->group(function () {
        Route::post('/SVlogin', 'SVlogin');
        Route::post('/Flogout', 'Flogout')->middleware('auth:sanctum');
        Route::post('/Parentlogin', 'ParentLogin');
        // Route::post('/refresh', 'refresh');
    });
    //apis SV App
    {
        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/getSVstudents', [SVappController::class, 'getrelatedStudents']); //SV
            Route::post('/getParentChild', [ParentAppController::class, 'getParentChild']); //Parent
            Route::get('/getstudent/{id}', [StudentController::class, 'getStudent']); //SV        
            Route::post('/updateLocation/{id}', [SVappController::class, 'Sharelocation']); //SV
            Route::get('/getStLoctaion/{id}', [ParentAppController::class, 'getStudentLoctaion']); //parent
        });
        /*   Route::post('/getSVstudents', [SVappController::class, 'getrelatedStudents']);
        Route::post('/getParentChild', [ParentAppController::class, 'getParentChild']);
        Route::get('/getstudent/{id}', [StudentController::class, 'getStudent']); */
    }
}
