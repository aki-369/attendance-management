<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [StampController::class, 'index'])->name('index');
    Route::post('/clock-in',[StampController::class, 'clockIn'])->name('clockIn');
    Route::post('/clock-out',[StampController::class, 'clockOut'])->name('clockOut');
    Route::post('/break-start',[StampController::class, 'breakStart'])->name('breakStart');
    Route::post('/break-end',[StampController::class, 'breakEnd'])->name('breakEnd');
});

Route::get('/register', [UserController::class, 'showRegisterForm']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'showAttendanceView']);
});