<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

### Clients Routes
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::patch('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'delete'])->name('clients.delete');

### Cars Routes
Route::delete('/cars/{car}', [CarController::class, 'delete'])->name('cars.delete');
Route::patch('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');

###Route::get('/clients/{client}/edit', [ClientController::class, 'show'])->name('clients.show');


