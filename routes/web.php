<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/',[HomeController::class,'index']);
Route::post('calculate-commission',[HomeController::class,'calculateCommission'])->name('calculate_commission');
