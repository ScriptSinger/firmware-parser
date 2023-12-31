<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\FirmwareController;
use App\Http\Controllers\SettingContrller;
use App\Http\Controllers\StatisticController;
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


Route::resource('/settings', SettingContrller::class);
Route::resource('/firmwares', FirmwareController::class);
Route::get('/', [StatisticController::class, 'index'])->name('statistic.index');
Route::get('/download/{filename}', [FirmwareController::class, 'downloadFile'])->name('download');
