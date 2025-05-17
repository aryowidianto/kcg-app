<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KalkulasiController;
use App\Http\Controllers\PrintingCalculationController;

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
    return view('dashboard');
});
Route::resource('kertas-plano', \App\Http\Controllers\KertasPlanoController::class);
Route::resource('mesin-offset', \App\Http\Controllers\MesinOffsetController::class);
Route::resource('tinta', \App\Http\Controllers\TintaController::class);


Route::get('/printing/calculation', [PrintingCalculationController::class, 'index'])->name('printing.calculation');
Route::post('/printing/calculate', [PrintingCalculationController::class, 'calculate'])->name('printing.calculate');





