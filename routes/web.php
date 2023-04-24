<?php

use App\Http\Controllers\V1\Attendance\AttendanceController;
use App\Http\Controllers\V1\Client\ClientController;
use App\Http\Controllers\V1\Department\DepartmentController;
use App\Http\Controllers\V1\Employee\EmployeeController;
use App\Http\Controllers\V1\Employee\ScheduleController;
use App\Http\Controllers\V1\Project\ProjectController;
use App\Http\Controllers\V1\Task\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

// department
Route::controller(DepartmentController::class)->group(function(){
    Route::get('form/departments/page','index')->name('form/departments/page');
    Route::post('form/departments/save','saveRecordDepartment')->name('form/departments/save');
    Route::post('form/departments/update','updateRecordDepartment')->name('form/departments/update');
});

// Employee
Route::controller(EmployeeController::class)->group(function(){
    Route::get('form/employees/page','index')->name('form/employees/page');
    Route::post('form/employees/store','store')->name('form/employees/store');
    Route::post('form/employees/update','update')->name('form/employees/update');
});

// Scedule
Route::controller(ScheduleController::class)->group(function(){
    Route::get('form/employees/schedule','index')->name('form/employees/schedule');
    Route::post('form/employees/schedule/save','store')->name('form/employees/schedule/save');
    Route::post('form/employees/schedule/update','update')->name('form/employees/schedule/update');
});

//attendance
Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
Route::post('check_store', [AttendanceController::class, 'check_store'])->name('check_store');

//Client
Route::controller(ClientController::class)->group(function(){
    Route::get('client','index')->name('client');
    Route::post('client/store','store')->name('client.store');
    Route::get('client/edit/{id}','edit')->name('client.edit');
    Route::put('client/update/{id}','update')->name('client.update');
});

//Project
Route::controller(ProjectController::class)->group(function(){
    Route::get('project','index')->name('project');
    Route::post('project/store','store')->name('project.store');
    Route::get('project/edit/{id}','edit')->name('project.edit');
    Route::put('project/update/{id}','update')->name('project.update');
});

//Task
Route::controller(TaskController::class)->group(function(){
    Route::get('task','index')->name('task');
    Route::get('task/{id}','show')->name('task.show');
    Route::post('task/store','store')->name('task.store');
    Route::put('task/update/{id}','update')->name('task.update');
    Route::put('task/uncheck/{id}','uncheck')->name('task.uncheck');
    // Route::get('project/edit/{id}','edit')->name('project.edit');
    // Route::put('project/update/{id}','update')->name('project.update');
});

Route::get('index',[ClientController::class, 'index'])->name('index');
