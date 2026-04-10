<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RecepcionistaController;

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

Route::get('/', function () {
    return view('auth.login'); //pide el logueo al inicio
    //return view('welcome');
});

//ruta para las recepcionistas
Route::resource('/recepcionista', 'App\Http\Controllers\RecepcionistaController');

//ruta para la inscripcion
Route::resource('/inscripcion', 'App\Http\Controllers\InscripcionController');

//ruta para pago de cuotas
Route::resource('/pago', 'App\Http\Controllers\PagoController');

//ruta para crear nueva cuota de pago
Route::get('/pago/{id}/create', 'App\Http\Controllers\PagoController@create');

//resumen de pagos
Route::get('/resumen-pagos','App\Http\Controllers\PagoController@index');

//ruta para ver reportes e informes
Route::PUT('/pdf',  [PDFController::class, 'getPDF']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
