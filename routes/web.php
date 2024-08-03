<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WaterConsumptionController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [WaterConsumptionController::class, 'index'])->name('water.index');
Route::get('/water/data', [WaterConsumptionController::class, 'getData'])->name('water.getData');
Route::post('/water/update-status', [WaterConsumptionController::class, 'updateStatus'])->name('water.updateStatus');
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
