<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WaterConsumptionController;


Route::post('/water', [WaterConsumptionController::class, 'storeUnits'])->name('water.storeUnits');
