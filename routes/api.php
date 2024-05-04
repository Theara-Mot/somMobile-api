<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LecturerLevelController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\YearController;
use App\Models\LecturerLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



// register
Route::post("register",[AuthController::class,"register"]);

// login
Route::post("login",[AuthController::class,"login"]);


Route::group([
    "middleware" => ["auth:sanctum"]
],function(){
    // profile
    Route::get("profile",[AuthController::class,"profile"]);
    Route::put("updateProfile",[AuthController::class,"updateProfile"]);
    Route::get("logout",[AuthController::class,"logout"]);

    // time 
    Route::get('/time', [TimeController::class, 'index']);
    Route::post('/time', [TimeController::class, 'store']);
    Route::get('/time/{id}', [TimeController::class, 'show']);
    Route::put('/time/{id}', [TimeController::class, 'update']);
    Route::delete('/time/{id}', [TimeController::class, 'destroy']);

    // day
    Route::get('/day', [DayController::class, 'index']);
    Route::post('/day', [DayController::class, 'store']);
    Route::get('/day/{id}', [DayController::class, 'show']);
    Route::put('/day/{id}', [DayController::class, 'update']);
    Route::delete('/day/{id}', [DayController::class, 'destroy']);

    // shift
    Route::get('/shift', [ShiftController::class, 'index']);
    Route::post('/shift', [ShiftController::class, 'store']);
    Route::get('/shift/{id}', [ShiftController::class, 'show']);
    Route::put('/shift/{id}', [ShiftController::class, 'update']);
    Route::delete('/shift/{id}', [ShiftController::class, 'destroy']);

    // classes
    Route::get('/class', [ClassController::class, 'index']);
    Route::post('/class', [ClassController::class, 'store']);
    Route::get('/class/{id}', [ClassController::class, 'show']);
    Route::put('/class/{id}', [ClassController::class, 'update']);
    Route::delete('/class/{id}', [ClassController::class, 'destroy']);

   // year
    Route::get('/year', [YearController::class, 'index']);
    Route::post('/year', [YearController::class, 'store']);
    Route::get('/year/{id}', [YearController::class, 'show']);
    Route::put('/year/{id}', [YearController::class, 'update']);
    Route::delete('/year/{id}', [YearController::class, 'destroy']); 

    // lecturer level
    Route::get('/lecturer_levels', [LecturerLevelController::class, 'index']);
    Route::post('/lecturer_levels', [LecturerLevelController::class, 'store']);
    Route::get('/lecturer_levels/{id}', [LecturerLevelController::class, 'show']);
    Route::put('/lecturer_levels/{id}', [LecturerLevelController::class, 'update']);
    Route::delete('/lecturer_levels/{id}', [LecturerLevelController::class, 'destroy']); 

    // department
    

});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/department', [DepartmentController::class, 'index']);
    Route::post('/department', [DepartmentController::class, 'store']);
    Route::get('/department/{id}', [DepartmentController::class, 'show']);
    Route::put('/department/{id}', [DepartmentController::class, 'update']);
    Route::delete('/department/{id}', [DepartmentController::class, 'destroy']); 
