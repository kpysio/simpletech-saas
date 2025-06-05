<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth'])->get('/employee/dashboard', [\App\Http\Controllers\EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
Route::middleware(['auth'])->get('{department}/employee/clients', [\App\Http\Controllers\EmployeeDashboardController::class, 'clients'])->name('employee.clients');
